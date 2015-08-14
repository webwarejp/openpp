OAuth2
======

# コマンドでのclientの登録



APIへのアクセスをOAuthサーバーで制御

アプリごとにトークンを払いだして、OAuth2認証をする。

サイト

    $ php app/console fos:oauth-server:client:create --redirect-uri=http://example.com --grant-type=token --grant-type=authorization_code ClientName

アプリ

    $ php app/console fos:oauth-server:client:create --redirect-uri=myschema://example.com/ --grant-type=password MyApp

サーバー間

    $ php app/console fos:oauth-server:client:create --redirect-uri=http://example.com --grant-type=client_credentials MyServer

--redirect-uri

    リダイレクトURIの設定。複数設定可。

--grant-type

    認証フロー。複数設定可。
  
    * authorization_code  認可コード（Authorization Code Grant Flow）
    * token               インプリシットグラント（Implicit Grant Flow）
    * password            リソースオーナーパスワードクレデンシャルグラント（Resource Owner Password Credentials Grant Flow)
    * client_credentials  クライアントクレデンシャルグラント（Client Credentials Grant Flow）
    * extensions

--name
  
    クライアントの名前。表示に使われます。
    

# 管理画面からの登録


管理画面からも登録できます。


## テスト


### 準備

    //テストユーザーの作成
    $ php app/console fos:user:create
    Please choose a username:test
    Please choose an email:test@example.com
    Please choose a password:test
    Created user test
    $ php app/console fos:user:activate test
    User "test" has been activated.
    $ php app/console fos:oauth-server:client:create --redirect-uri=http://example.com --grant-type=token --grant-type=authorization_code ClientName
    Added a new client with public id 8_d5tu7jec5xs8w4g0osscs8808804kg480kw404o8cg0cgskkg, secret 2ytibvq5y9q8o840w0k8swoksg0okokwc4kwkws08ow4k0wwc8

### Authorization Code Grant Flow

    
    ブラウザで以下の URL にアクセス。plublic id を client_id に設定。
    http://openpp.tld/app_dev.php/oauth/v2/auth?client_id=8_d5tu7jec5xs8w4g0osscs8808804kg480kw404o8cg0cgskkg&response_type=code&redirect_uri=http%3A%2F%2Fexample.com
    {"error":"access_denied","error_description":"OAuth2 authentication required"}
    
    ログインリダイレクトされるので、準備で作成したユーザーのID/passwordを入力。
    
    認可ページで認可ボタンを押す。
    
    リダイレクトされたページのcodeのパラメータが認可コード。
    http://example.com/?code=ZTk1ZWMyYjM5OTgyYjY0NzdhNzE3ZDBlZTU0OTQzNjBjYmVhYWMzZmE1MzNjZjY1YzJmZmYwYTZhNzc1ZWUxNA
    
    最後にtokenの取得
    http://openpp.tld/app_dev.php/oauth/v2/token?client_id=8_d5tu7jec5xs8w4g0osscs8808804kg480kw404o8cg0cgskkg&client_secret=2ytibvq5y9q8o840w0k8swoksg0okokwc4kwkws08ow4k0wwc8&grant_type=authorization_code&redirect_uri=http%3A%2F%2Fexample.com&code=ZTk1ZWMyYjM5OTgyYjY0NzdhNzE3ZDBlZTU0OTQzNjBjYmVhYWMzZmE1MzNjZjY1YzJmZmYwYTZhNzc1ZWUxNA
    問題ない場合は以下の様なレスポンスが帰ってくるはず。
    {"access_token":"ODAzNjdlZTRkZjhlZWFmODNiY2FhZWRlMWYyYWQ0ZTRhNjk5NTBmMjZhYjUwYWUwMWZhYzk2ZDliZDgzMzk5ZA","expires_in":3600,"token_type":"bearer","scope":null,"refresh_token":"ZmNmNWU3OTk5MjdhNzcyMmNjMDUxYjY0ZWM4NDZiYzgwMjViNDIwODcxZjQ4ZTFhMGJjZDQxOWU1NDY3MTE3NA"}
    
    実際にAPIを叩いて情報を取得する。
    http://openpp.tld/app_dev.php/api/user/me.json?access_token=ODAzNjdlZTRkZjhlZWFmODNiY2FhZWRlMWYyYWQ0ZTRhNjk5NTBmMjZhYjUwYWUwMWZhYzk2ZDliZDgzMzk5ZA
    {"uid":157}
    
<!---
    リフレッシュトークン
--->

### Implicit Grant Flow

    以下のURLにアクセス。
    http://openpp.tld/app_dev.php/oauth/v2/auth?client_id=8_d5tu7jec5xs8w4g0osscs8808804kg480kw404o8cg0cgskkg&redirect_uri=http%3A%2F%2Fexample.com&response_type=token
    ログインフォームが表示され、id/passを入力し、認可のボタンを押す。
    リダイレクト先のURLのパラメーターからaccess_tokenが得られる。
    http://example.com/#access_token=NzdmMWQyYmVkOTFjY2MxNTQzNWZlMGIyNDcwODAwZTU4OTFmMjJjODJkY2Y3MTRjMjJiNjU4YzM5OWMyMTJiYg&expires_in=3600&token_type=bearer
    
    リダイレクトされ、access_tokenのパラメーターが付いていることを確認。
    実際にAPIを叩いて情報を取得。
    http://openpp.tld/app_dev.php/api/user/me.json?access_token=NzdmMWQyYmVkOTFjY2MxNTQzNWZlMGIyNDcwODAwZTU4OTFmMjJjODJkY2Y3MTRjMjJiNjU4YzM5OWMyMTJiYg
    {"uid":157}
    
### Resource Owner Password Credentials Grant Flow

    $ php app/console fos:oauth-server:client:create --redirect-uri=my-mobile-app://oauth/callback --grant-type=password myApp
    Added a new client with public id 9_60b5hc59tzksoow4g0ok4co4cwwggowg8s8ssgsks8o4k4kogw, secret 4m3tnuxiziuc00cososoossscg0skk0wk48oksc4wgg4g4wwo4
    
    curl コマンドで実施。トークンを取得。
    $ curl -d "grant_type=password" \
           -d "client_id=9_60b5hc59tzksoow4g0ok4co4cwwggowg8s8ssgsks8o4k4kogw" \
           -d "client_secret=4m3tnuxiziuc00cososoossscg0skk0wk48oksc4wgg4g4wwo4" \
           -d "username=test" \
           -d "password=test" \
           http://openpp.tld/app_dev.php/oauth/v2/token
    {"access_token":"MzVmNjc0YmNjM2I4NjFlNjA0YzViOGNmNjZkNzM0MDkwMDE4Nzk2NWQ5YjFhMmM4ZjZhODBhYWY0MmQ2ZmZlYw","expires_in":3600,"token_type":"bearer","scope":null,"refresh_token":"NjAwZTkxZTU2ZGM2NWE2ZDY5NDJmNThlYTYyY2EyNDYxNDUxOTBiZGFiYTI0MmFmZWY5NTljNTNjNzg1Yjk3Nw"}
    
    実際にAPIを叩いて情報を取得。
    $ curl "http://openpp.tld/api/user/me.json?access_token=MzVmNjc0YmNjM2I4NjFlNjA0YzViOGNmNjZkNzM0MDkwMDE4Nzk2NWQ5YjFhMmM4ZjZhODBhYWY0MmQ2ZmZlYw" 
    {"uid":157}

### Client Credentials Grant Flow

    $ php app/console fos:oauth-server:client:create --redirect-uri=my-mobile-app://oauth/callback --grant-type=client_credentials myServer
    Added a new client with public id 10_5vx893tpbd0k8kk0kkscw4c48gskwcs8ww0ww0go80ooo00s4o, secret 53fueleq04g0s4kkc40cgk440owc4wgkw484ccgwwswwkwk8g8
    
    $ curl     -d "grant_type=client_credentials" \
               -d "client_id=10_5vx893tpbd0k8kk0kkscw4c48gskwcs8ww0ww0go80ooo00s4o" \
               -d "client_secret=53fueleq04g0s4kkc40cgk440owc4wgkw484ccgwwswwkwk8g8" \
               http://openpp.tld/app_dev.php/oauth/v2/token
    {"access_token":"Yjg1NDBiZjg5NGNiMWIzYjZkODA5MzZlMWNmM2E3YjIzM2MzN2Q3ZGUxYzNlYjI5NjU3NjgxMWM3NmRjMzkyOQ","expires_in":3600,"token_type":"bearer","scope":null}
    
    $ curl "http://openpp.tld/api/user/me.json?access_token=Yjg1NDBiZjg5NGNiMWIzYjZkODA5MzZlMWNmM2E3YjIzM2MzN2Q3ZGUxYzNlYjI5NjU3NjgxMWM3NmRjMzkyOQ"
    {"code":404,"message":"User is null."}




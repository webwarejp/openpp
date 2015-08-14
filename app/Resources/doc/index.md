OpenPP
======

# Installation

    $ git clone https://github.com/webwarejp/openpp.git
    $ cd openpp
    $ composer install
    $ curl -L https://github.com/yui/yuicompressor/releases/download/v2.4.8/yuicompressor-2.4.8.jar > bin/yuicompressor.jar
    $ php app/console doctrine:database:create
    $ php bin/load_data.php
    $ chmod -R 0777 web/uploads

[postgresqlでの利用](postgresql.md)

[oauth2](oauth2.md)


<!---
記事の作成

テンプレートのいじり方

PUSH通知の設定

API

-->
PostgreSQL での利用
==================

geometry 型が標準で入っていませんので、 
doctrine:database:createでエラーになります。
そのため、postgis を用います。

* [PostGIS](http://postgis.net/)
* [CentOS6へのインストール方法](http://trac.osgeo.org/postgis/wiki/UsersWikiPostGIS21CentOS6pgdg)

以下から適切なレポジトリを選び、パッケージをインストール。
[repopackages](http://yum.postgresql.org/repopackages.php)

例)CentOS7

    $ sudo rpm -ivh http://yum.postgresql.org/9.4/redhat/rhel-7-x86_64/pgdg-centos94-9.4-1.noarch.rpm
    $ sudo yum install postgis2_94
    
テンプレートの作成。

    $ createdb -U postgres postgistemplate
    $ createlang -U postgres plpgsql postgistemplate
    $ psql -U postgres postgistemplate -f /usr/pgsql-9.4/share/contrib/postgis-2.1/postgis.sql 
    $ psql -U postgres postgistemplate -f /usr/pgsql-9.4/share/contrib/postgis-2.1/spatial_ref_sys.sql

利用するDBの作成。

    $ createdb  -T postgistemplate -U postgres openpp
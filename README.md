Rados
=====

an OOP php class for RADOS


## Dependency

- PHP 5.4+
- Rados Extension [ceph/phprados](https://github.com/ceph/rados)

## Initialize

```php
$radosCluster = new Rados\Cluster();
$radosCluster->readConfig('/path/to/your/ceph/config');

$radosCluster->ceatreIO('pool_name');
```

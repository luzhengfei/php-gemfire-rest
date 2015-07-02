# php-gemfire-rest
Geode分布式数据php api
//使用前需要从gfsh里创建region,create region --name=user_profile --type=REPLICATE

require_once '../PHPGeodeClient.Api.php';
$geode = new PHPGeodeClient("192.168.199.132","8080");

//列出所有域，域的可以理解成mongodb的集合。

$re = $geode->list_all_regions();
print_r($re->getRespondData());

//创建数据，k->v格式，v可以是关联数组

$re = $geode->create('user_profile','ccc',array('cccc','dddd' => 'aaaaa'));
print_r($re->getRespondData());

$re = $geode->create('user_profile','xt',array('name' => 'xt','age' => 50));
print_r($re->getRespondData());

//获取user_profile这个域的所有数据

$re = $geode->get_region_all('user_profile');
print_r($re->getRespondData());

//获取域的所有键

$re = $geode->get_region_keys('user_profile');
print_r($re->getRespondData());

//根据键获取实体数据

$re = $geode->get_entries_by_keys('user_profile',array('ccc'));
print_r($re->getRespondData());

$data = array(
        'name' => 'lzf',
        'age' => 23
);
$re = $geode->update('user_profile','ccc',$data);

//创建查询，不会查询数据，执行查询时才会

$re = $geode->create_queries('sel','select * from /user_profile');

//$re = $geode->update_queries('sel','select * from /user_profile where name=\'lzf\'');

$re = $geode->update_queries('sel','select * from /user_profile where age>10');

//执行查询

$re = $geode->execute_queries('sel');
print_r($re->getRespondData());

//列出所有查询

$re = $geode->list_queries();
print_r($re->getRespondData());

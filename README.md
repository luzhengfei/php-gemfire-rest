# php-gemfire-rest
Geode分布式数据php api

require_once '../PHPGeodeClient.Api.php';
$geode = new PHPGeodeClient("192.168.199.132","8080");

$re = $geode->list_all_regions();
print_r($re->getRespondData());

$re = $geode->create('user_profile','ccc',array('cccc','dddd' => 'aaaaa'));
print_r($re->getRespondData());

$re = $geode->create('user_profile','xt',array('name' => 'xt','age' => 50));
print_r($re->getRespondData());

$re = $geode->get_region_all('user_profile');
print_r($re->getRespondData());

$re = $geode->get_region_keys('user_profile');
print_r($re->getRespondData());

$re = $geode->get_entries_by_keys('user_profile',array('ccc'));
print_r($re->getRespondData());

$data = array(
        'name' => 'lzf',
        'age' => 23
);
$re = $geode->update('user_profile','ccc',$data);

$re = $geode->create_queries('sel','select * from /user_profile');

//$re = $geode->update_queries('sel','select * from /user_profile where name=\'lzf\'');

$re = $geode->update_queries('sel','select * from /user_profile where age>10');

$re = $geode->execute_queries('sel');
print_r($re->getRespondData());

$re = $geode->list_queries();
print_r($re->getRespondData());

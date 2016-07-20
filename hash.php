<?php
/*
 * 连接redis
 */
$redis = new redis();
$redis->connect('localhost', 6379);

/*
 * 密码认证
 */
$redis->auth('123456');


/*
 * hSet
 * 将哈希表key中的域field的值设为value。如果key不存在，一个新的哈希表被创建并进行HSET操作。如果域field已经存在于哈希表中，旧值将被覆盖。
 *
 * @param string key 哈希表key
 * @param string field key的域
 * @param string value 域的值
 * @return 设置成功，返回1，如果field已经存在且旧值已被新值覆盖，返回0。
 */
$redis->hSet('member', 'name', 'nick'); 
var_dump($redis->hGet('member', 'name'));

/*
 * hSetNx
 * 将哈希表key中的域field的值设置为value，当且仅当域field不存在。若域field已经存在，该操作无效。如果key不存在，将创建一张新的哈希表。
 *
 * @param string key 哈希表key
 * @param string field key的域
 * @param string value 域的值
 * @return 设置成功，返回1。如果给定域已经存在且没有操作被执行，返回0。
 */
$redis->hSetNx('member', 'name', 'tony');
var_dump($redis->hGet('member', 'name'));

/*
 * hLen
 * 返回哈希表key中域的数量，如果key不存在则返回0。 
 *
 * @param string key 哈希表key
 * @return int
 */
var_dump($redis->hLen('member'));

/*
 * hDel
 * 删除哈希表key中的一个或多个指定域，不存在的域将被忽略。
 *
 * @param string key 哈希表key
 * @param string field [field ...]
 * @return int
 */
var_dump($redis->hDel('member','name','iphone'));

$redis->delete('member');
$redis->hSet('member', 'name', 'mayer');
$redis->hSet('member', 'sex', 'man');
$redis->hSet('member', 'mobile', '15920370150');

/*
 * hKeys
 * 返回哈希表key中的所有域
 *
 * @param string key 哈希表key
 * @return 一个包含哈希表中所有域的表。当key不存在时，返回一个空表。
 */
var_dump($redis->hKeys('member'));  
 
/*
 * hVals
 * 返回哈希表key中的所有值
 *
 * @param string key 哈希表key
 * @return 一个包含哈希表中所有值的表。当key不存在时，返回一个空表。
 */
var_dump($redis->hVals('member'));
 
/*
 * hGetAll
 * 返回哈希表key中的所有域和值
 *
 * @param string key 哈希表key
 * @return 以列表形式返回哈希表的域和域的值。
 */
var_dump($redis->hGetAll('member'));  
 
/*
 * hExists
 * 查看哈希表key中，给定域field是否存在。 
 *
 * @param string key 哈希表key
 * @param string field 域
 * @return bool
 */
var_dump($redis->hExists('member', 'name'));  
 
$redis->delete('member'); 

/*
 * hInrcBy
 * 为哈希表key中的域field的值加上增量increment。增量也可以为负数，相当于对给定域进行减法操作，如果key不存在，则或新创建一张哈希表，如果域存在并且值为数字则数字累加，如果为字符串则返回false，如果域不存在则添加该域。。
 *
 * @param string key 哈希表key
 * @param string field 域
 * @param int value 要增加的数字
 * @return int或false
 */
var_dump($redis->hIncrBy('member', 'name', 3));
var_dump($redis->hGetall('member'));  
var_dump($redis->hIncrBy('member', 'name', 1));
 
$redis->delete('member');

/**
 * zmSet
 * 同时将多个field - value(域-值)对设置到哈希表key中。此命令会覆盖哈希表中已存在的域。如果key不存在，一个空哈希表被创建并执行hmSet操作。
 *
 * @param key string 键
 * @param  array[field(bool)=>value(mixed)] field-value键值对
 * @return bool
 */
var_dump($redis->hmSet('member', array('name' =>'tony', 'sex'=>"man")));

/**
 * zmGet
 * 返回哈希表key中，一个或多个给定域的值。如果给定的域不存在于哈希表，那么返回一个null值。因为不存在的key被当作一个空哈希表来处理，所以对一个不存在的key进行hmGet操作将返回一个只带有null值的表。
 *
 * @param key string 键
 * @param  array[field,field] field-value键值对
 * @return array
 */
var_dump($redis->hmGet('member', array('name', 'sex')));
?>

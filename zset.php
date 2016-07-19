<?php
/**
 * Redis Sort Set
 * @author mayer
 */

$redis = new redis();

/**
 * connect
 *
 * @param host string 服务地址
 * @param port int 端口号
 * @param timeout float 链接时长，可选, 默认为 0 ，不限链接时间（redis.conf中也有时间，默认为300）
 */
$redis->connect('192.168.79.140', 6379);

/**
 * auth
 * 如果Redis设置的密码验证，则需要使用该方法验证
 *
 * @param password string 密码
 */
$redis->auth('123456');

/**
 * zAdd
 * 向名称为key的zset中添加元素member，score用于排序。如果该元素已经存在，则根据score更新该元素的顺序
 *
 * @param key string 键
 * @param score double 权重值
 * @param member string 元素
 * @return int
 */
$redis->zAdd('point',0,'zero');
$redis->zAdd('point',1,'one');
$redis->zAdd('point',2,'two');
$redis->zAdd('point',3,'three');
$redis->zAdd('point',4,'four');
$redis->zAdd('point',5,'five');
$redis->zAdd('point',6,'six');
$redis->zAdd('point',7,'seven');
$redis->zAdd('point',8,'eight');
$redis->zAdd('point',9,'nine');

/**
 * zRange
 * 返回名称为key的zset（元素已按score从小到大排序）中的索引从start到end的所有元素
 *
 * @param key string 键
 * @param start int 开始索引
 * @param end int 结束索引
 * @param withscores bool 可选，默认为false，不返回权重值score
 * @return array
 */
var_dump($redis->zRange('point',0,-1));
$redis->zAdd('point',99,'nine');
var_dump($redis->zRange('point',0,-1,true));

/**
 * zDelete
 * 删除名称为key的zset中的元素member
 *
 * @param key string 键
 * @param member string 元素
 * @return int
 */
$redis->zDelete('point','nine');
var_dump($redis->zRange('point',0,-1,true));

/**
 * zRevRange
 * 返回名称为key的zset（元素已按score从大到小排序）中的索引从start到end的所有元素
 *
 * @param key string 键
 * @param start int 开始索引
 * @param end int 结束索引
 * @param withscores bool 可选，默认为false，不返回权重值score
 * @return array
 */
var_dump($redis->zRevRange('point',0,-1,true));

/**
 * zRangeByScore
 * 返回key对应的有序集合中score介于min和max之间的所有元素（包哈score等于min或者max的元素），元素按照score从低到高的顺序排列，如果元素具有相同的score，那么会按照索引排列
 *
 * @param key string 键
 * @param min float 最小权重值
 * @param max float 最大权重值
 * @param options array[withscores(bool),limit(array[offset,rows])] 可选的选项limit可以用来获取一定范围内的匹配元素，可选的选项withscores可以使得在返回元素的同时返回元素的score
 * @return array
 */
var_dump($redis->zRangeByScore('point', 1, 5, array('limit' => array(3, 3),'withscores' => true)));

/**
 * zRevRangeByScore
 * 返回key对应的有序集合中score介于max和min之间的所有元素（包哈score等于max或者min的元素），元素按照score从高到低的顺序排列，如果元素具有相同的score，那么会按照索引排列
 *
 * @param key string 键
 * @param max float 最大权重值
 * @param min float 最小权重值
 * @param options array[withscores(bool),limit(array[offset,rows])] 可选的选项limit可以用来获取一定范围内的匹配元素，可选的选项withscores可以使得在返回元素的同时返回元素的score
 * @return array
 */
var_dump($redis->zRevRangeByScore('point', 5, 1, array('limit' => array(3, 1),'withscores' => true)));

/**
 * zSize
 * 返回名称为key的zset的所有元素的个数
 *
 * @param key string 键
 * @return int
 */
var_dump($redis->zSize('point'));

/**
 * zCount
 * 返回key对应的有序集合中score值在min和max之间(包括score值等于min或max)的成员的数量
 *
 * @param key string 键
 * @param min float 最小权重值
 * @param max float 最大权重值
 * @return int
 */
var_dump($redis->zCount('point', 1, 5));

/**
 * zRank
 * 返回key对应的有序集合中member元素的索引值，元素按照score从低到高进行排列，如果member在有序集合中不存在，那么将会返回false
 *
 * @param key string 键
 * @param member string 元素
 * @return int
 */
var_dump($redis->zRank('point', 'three'));

/**
 * zRevRank
 * 返回key对应的有序集合中member元素的索引值，元素按照score从高到低进行排列，如果member在有序集合中不存在，那么将会返回false
 *
 * @param key string 键
 * @param member string 元素
 * @return int
 */
var_dump($redis->zRevRank('point', 'three'));

/**
 * zScore
 * 返回key对应的有序集合中member的score值，如果member在有序集合中不存在，如果member在有序集合中不存在，那么将会返回false
 *
 * @param key string 键
 * @param member string 元素
 * @return float
 */
var_dump($redis->zScore('point','six'));

/**
 * zDeleteRangeByScore
 * 删除key对应的有序集合中scroe位于min和max(包括score值等于min或max)之间的所有元素，返回删除个数
 *
 * @param key string 键
 * @param min float 最小权重值
 * @param max float 最大权重值
 * @return int
 */
var_dump($redis->zDeleteRangeByScore('point',7,8));
var_dump($redis->zRange('point',0,-1,true));

/**
 * zDeleteRangeByRank
 * 删除key对应的有序集合中索引值介于start和end之间的所有元素，返回删除个数
 *
 * @param key string 键
 * @param start int 开始索引
 * @param end int 结束索引
 * @return array
 */
var_dump($redis->zDeleteRangeByRank('point',-3,-1));
var_dump($redis->zRange('point',0,-1,true));

$redis->zAdd('other',5,'one');
$redis->zAdd('other',7,'two');
$redis->zAdd('other',8,'four');
$redis->zAdd('other',10,'five');
var_dump($redis->zRange('other',0,-1,true));

/**
 * zUnion
 * 对多个zset求合集，并将最后的集合保存在key中
 *
 * @param key string 并集存放结果的key
 * @param zsets array[key1,key2,...] 用于计算并集的有序集合的key组成的数组
 * @param weights array[key1ScoreWeight,key2ScoreWeight,...] 可选，默认为1，计算并集之前各个有序集合元素权重要乘以的基数
 * @param aggregate string 可选，默认为sum.即计算并集时相同的元素score值相加，min表示计算并集时相同元素score取最小的，max表示计算并集时相同元素score取最大的
 * @return array
 */
$redis->zUnion('union',array('point','other'),array(2,1),'MIN');
var_dump($redis->zRange('union',0,-1,true));

/**
 * zInter
 * 对多个zset求交集，并将最后的集合保存在key中
 *
 * @param key string 并集存放结果的key
 * @param zsets array[key1,key2,...] 用于计算并集的有序集合的key组成的数组
 * @param weights array[key1ScoreWeight,key2ScoreWeight,...] 可选，默认为1，计算并集之前各个有序集合元素权重要乘以的基数
 * @param aggregate string 可选，默认为sum.即计算并集时相同的元素score值相加，min表示计算并集时相同元素score取最小的，max表示计算并集时相同元素score取最大的
 * @return array
 */
$redis->zInter('inter',array('point','other'),array(2,3));
var_dump($redis->zRange('inter',0,-1,true));

/**
 * zIncrby
 * 将key对应的有序集合中member元素的scroe加上increment，如果指定的member不存在，那么将会添加score的初始值为increment的该元素，如果key不存在，那么将会创建一个新的有序列表。返回member的权重值
 *
 * @param key string 键
 * @param increment float 权重值增量
 * @param member string 元素
 * @return float
 */
var_dump($redis->zIncrby('inter',5,'three'));
var_dump($redis->zRange('inter',0,-1,true));

$redis->delete('point');
$redis->delete('other');
$redis->delete('union');
$redis->delete('inter');

?>

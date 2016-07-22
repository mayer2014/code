<?php
/**
 * Redis List
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
$redis->delete('list');
$redis->delete('list2');

/**
 * lPush/rPush
 * 往列表头部(左/右)添加一个或多个元素，如果key不存在则新建一个list容器，如果key存在且不是list则返回false
 *
 * @param key string 键
 * @param score double 权重值
 * @param member string 元素
 * @return int 列表长度
 */
var_dump($redis->lPush('list',1));
var_dump($redis->rPush('list',2,3));

/**
 * lPushx/rPushx
 * 往列表头部(左/右)添加一元素，如果key不存在则操作无效，如果key存在且不是list则返回false
 *
 * @param key string 键
 * @param score double 权重值
 * @param member string 元素
 * @return int 列表长度
 */
var_dump($redis->rPushx('list',4));

/**
 * lGet
 * 返回列表key中，下标为index的元素，如果key不存在或不是list则返回false
 *
 * @param key string 键
 * @param index int 索引下标
 * @return 列表中下标为index的元素，如果index不存在则返回null
 */
var_dump($redis->lGet('list',0));

/**
 * lSet
 * 将列表key下标为index的元素的值设置为value，当index参数超出范围，或对一个空列表（不存在）进行设置时返回false
 *
 * @param key string 键
 * @param index int 索引下标
 * @param value mixed 列表元素
 * @return bool 
 */
var_dump($redis->lSet('list',0,10));

/**
 * lPop/rPop
 * 移除并返回列表key的头(左)/尾(右)元素，列表为空返回null，key不存在则返回false。
 *
 * @param key string 键
 * @return mixed
 */
var_dump($redis->lPop('list'));
var_dump($redis->rPop('list'));

/**
 * lSize
 * 返回列表key的长度，如果key不存在，则key被解释为一个空列表，返回0，如果key不是列表类型，返回一个false
 *
 * @param key string 键
 * @return int
 */
var_dump($redis->lSize('list'));

/**
 * blPop/brPop
 * lPop命令的阻塞版本，当给定列表内没有任何元素可供弹出的时候，连接将被blPop命令阻塞，直到等待超时或发现可弹出元素为止。
 * 当给定多个key参数时，按参数key的先后顺序依次检查各个列表，弹出第一个非空列表的头元素。
 * 如果所有给定key都不存在或包含空列表，那么blPop命令将阻塞连接，直到等待超时，或有另一个客户端对给定key添加元素,如果超时仍然为空，则返回空列表，超时参数设为0表示阻塞时间可以无限期延长。
 * 相同的key可以被多个客户端同时阻塞，不同的客户端被放进一个队列中，按先阻塞先服务的顺序为key执行命令。
 *
 * @param key [key...] string 键
 * @param timeout int
 * @return mixed
 */
var_dump($redis->blPop('list','list2',3));
var_dump($redis->lPush('list',1));
var_dump($redis->rPush('list',2));

/**
 * lRange
 * 返回列表key中指定区间内的元素，区间以偏移量start和stop指定，也可以使用负数下标，以-1表示列表的最后一个元素。
 * 超出范围的下标值不会引起错误，如果start下标比列表的最大下标还要大，或者start > stop，LRANGE返回一个空列表。
 *
 * @param key string 键
 * @param start int 开始下标
 * @param end int 结束下标
 * @return array
 */
var_dump($redis->lRange('list',0,-1));

/**
 * lTrim
 * 只保留指定区间内的元素，不在指定区间之内的元素都将被删除，可以使用负数下标，以-1表示列表的最后一个元素，当key不是列表类型时返回false
 * 如果start下标比列表的最大下标end大，或者start > stop，lTrim删除所有元素
 *
 * @param key string 键
 * @param start int 开始下标
 * @param end int 结束下标
 * @return bool
 */
var_dump($redis->lTrim('list',1,1));
var_dump($redis->lRange('list',0,-1));
var_dump($redis->lPush('list',1,0,1));
var_dump($redis->lPush('list',0));
var_dump($redis->lPush('list',1));
var_dump($redis->lPush('list',0));
var_dump($redis->lPush('list',1));
var_dump($redis->lPush('list',0));
var_dump($redis->lRange('list',0,-1));

/**
 * lRem
 * 根据参数count的值，移除列表中与参数value相等的元素
 *
 * @param key string 键
 * @param value int 开始下标
 * @param count int 结束下标,小于0则从表尾开始向表头搜索，等于0则移除全部
 * @return int 移除的元素数量
 */
var_dump($redis->lRem('list',1,-1));
var_dump($redis->lRange('list',0,-1));
var_dump($redis->lRem('list',1,-1));
var_dump($redis->lRange('list',0,-1));

/**
 * lInsert
 * 将值value插入到列表key当中，位于值pivot之前或之后，当key不存在或当pivot不存在于列表key时，不执行任何操作，如果key不是列表则返回false
 *
 * @param key string 键
 * @param Redis::AFTER | Redis::BEFORE
 * @param povit string 相对元素
 * @param value string 要插入的元素
 * @return int 列表长度
 */
var_dump($redis->lInsert('list', Redis::AFTER, 1, 'Y'));
var_dump($redis->lRange('list',0,-1));

/**
 * rPoplPush
 * 将列表source中的最后一个元素(尾元素)弹出，并返回给客户端，将source弹出的元素插入到列表destination，作为destination列表的的头元素。
 * 该方法存在对应的阻塞版本brPopPush
 *
 * @param scouce list 
 * @param destination list 开始下标
 * @return mixed被移出的元素
 */
var_dump($redis->rPoplPush('list','list2'));
var_dump($redis->lRange('list',0,-1));
var_dump($redis->lRange('list2',0,-1));

?>

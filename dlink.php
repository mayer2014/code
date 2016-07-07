<?php
/** 
 * 双向链表实现用户排行榜
 *
 * 仅用于体现逻辑，不具备实际参考价值，后面会介绍PHP内部实现的双向列表，有兴趣的可以看看
 * @author 疯狂老司机
 * @date 2016-07-07
 */  
class Rank{  

    /**
     * @var 指向前一个节点的引用
     */
    public $pre = null;

    /**
     * @var 指向后一个节点的引用
     */
    public $next = null;

    /**
     * @var 用户排行id
     */
    public $id;

    /**
     * @var 用户名称
     */
    public $username;
      
    public function __construct($id = '', $username = ''){
        $this->id = $id;
        $this->username = $username;
    }

    /**
     * 添加成员节点方法
     *
     * @access public
     * @param obj head 初始节点
     * @param obj rank 成员节点
     */
    public static function addRank($head, $rank){
        $cur = $head; // 辅助节点
        $isExist = false; //这是一个标志位

        while($cur->next != null){ 
            if($cur->next->id > $rank->id){
                break;
            }else if($cur->next->id == $rank->id){
                $isExist = true;
                echo'<br/>不能添加相同的id';  
            }  
            $cur = $cur->next;  
        }  

        if(!$isExist){ 
            if($cur->next != null){  
                $rank->next = $cur->next;  
            }  
            $rank->pre = $cur;  
            if($cur->next != null){  
                $cur->next->pre = $rank;  
            }  
            $cur->next = $rank;  
        }  
    }  

    /**
     * 删除成员节点方法
     *
     * @access public
     * @param obj head 初始节点
     * @param obj rankid 用户排行id
     */
    public static function delRank($head, $rankid){  
        $cur = $head->next;
        $isFind = flase; // 标记位

        while($cur != null){
            if($cur->id == $rankid){
                $isFind = true;
                break;
            }
            $cur = $cur->next;
        }  

        if($isFind){
            if($cur->next != null){
                $cur->next->pre = $cur->pre;
            }
            $cur->pre->next = $cur->next;
            echo '<br/>要删除的成员id是'.$cur->id;
        }else{
            echo'<br/>要删除的成员没有';
        }
    }

    /**
     * 遍历所有节点并输出显示
     *
     * @access public
     * @param obj head 初始节点
     */
    public static function showRank($head){
        $cur = $head->next; // 不打印空节点
        while($cur->next != null){
            echo'<br/>id='.$cur->id.'  '.'username='.$cur->username;
            $cur = $cur->next;
        }
        echo'<br/>id='.$cur->id.'  '.'username='.$cur->username;  
    }  
}  

//创建一个初始节点
$head=new Rank();

//创建一个成员
$rank=new Rank(1,'老王');
Rank::addRank($head,$rank);

$rank=new Rank(2,'小明');
Rank::addRank($head,$rank);

$rank=new Rank(6,'大熊');
Rank::addRank($head,$rank);

$rank=new Rank(3,'静香');
Rank::addRank($head,$rank);

$rank=new Rank(56,'孙二娘');
Rank::addRank($head,$rank);

echo '<br/>成员排行榜.....';
Rank::showRank($head);

echo'<br/>';
echo '<br/>删除后的成员排行榜.....';
Rank::delRank($head,3);
Rank::showRank($head);

echo'<br/>';
echo'<br/>下面测试删除最前面的和最后面的成员<br/>';
echo '<br/>删除后的成员排行榜.....';
Rank::delRank($head,1);
Rank::showRank($head); 

echo'<br/>';
echo '<br/>删除后的成员排行榜.....';
Rank::delRank($head,56);
Rank::showRank($head);
?>

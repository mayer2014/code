<?php  
/** 
 * SimpleFactory
 * User: Mayer
 * Date: 2016/7/25
 * Time: 15:37
 */  
  
/**
 * 抽象角色(哺乳动物)
 * Interface Mammal  抽象接口 
 */  
interface Mammal {
    /**
     * feature
     * @return mixed 
     */  
    public function feature();
  
    /**
     * eat
     * @return mixed 
     */  
    public function eat();
}  
  
/**
 * 具体角色 
 * Class Cat  猫(哺乳动物的一种)
 */
class Cat implements Mammal {
    private $number;
  
    public function __construct($number = 1) {
        $this->number=$number; 
    }  

    /**
     * 输出动物特征
     */
    public function feature() {  
        echo "您好，我是哺乳动物，我每小时能跑百公里，抓到的老鼠能绕地球三圈！\n";
    }  

    /**
     * 输出动物吃相
     */
    public function eat() {  
        echo "您好，我是哺乳动物，我一分钟能吃掉十只老鼠！\n";
    }  
}  
  
/**
 * 具体角色 
 * Class Dog  狗(哺乳动物的一种)
 */
class Dog implements Mammal {
    private $number;
  
    public function __construct($number = 2) {
        $this->number=$number;
    }
  
    /**
     * 输出动物特征
     */
    public function feature() {
        echo "您好，我是哺乳动物，我每小时能跑百公里，盗贼搭了飞机也能追上！\n";
    }

    /**
     * 输出动物吃相
     */
    public function eat() {
        echo "您好，我是哺乳动物，每天要吃三十斤狗粮！\n";
    }
}
  
/**
 * 具体角色 
 * Class Cow  牛(哺乳动物的一种)
 */
class Cow implements Mammal {
    private $number;
  
    public function __construct($number = 3) {
        $this->number=$number;
    }

    /**
     * 输出动物特征
     */
    public function feature() {
        echo "您好，我是哺乳动物，我每小时能耕十亩地，而且还累不死！\n";
    }

    /**
     * 输出动物吃相
     */
    public function eat() {
        echo "您好，我是哺乳动物，每天要吃二十斤青草！\n";
    }
}

/**
 * 工厂角色(谜语生成器)
 * Class RiddleFactory
 */  
class RiddleFactory {
    static public function GetRiddle($number) {
        if($number===1) {
            return new Cat;
        }
        if($number===2) {
            return new Dog;
        }
        if($number===3) {
            return new Cow;
        } 
        else {
            return null;
        }
    }  
}

// 测试代码
$number = mt_rand(1,3);
$raddle = RiddleFactory::GetRiddle($number);
$raddle->feature();
$raddle->eat();

?>

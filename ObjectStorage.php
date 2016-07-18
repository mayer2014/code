<?php
/**
 * 对象容器是用来存储一组对象的，特别是当你需要唯一标识对象的时候
 * 
 * @author  Mayer
 * @since PHP 5.1.2
 */
class ObjectStorage implements Iterator, Countable, ArrayAccess, Serializable {

    /** 
     * @var storage 数组容器
     */
    private $storage = array();

    /** 
     * @var storage 数组指针
     */
    private $index = 0;

    /**
     * 重置迭代指针
     * Rewind the iterator to the first storage element
     */
    public function rewind() {
        reset($this->storage);
        $this->index = 0;
    }
    
    /**
     * 判断迭代指针指向的元素是否有效
     * @return  if the current iterator entry is valid
     */
    public function valid() {
        return key($this->storage) !== NULL;
    }
    
    /**
     * 获取迭代指针偏移值
     * @return the index at which the iterator currently is
     */
    public function key() {
        return $this->index;
    }
    
    /**
     * 获取迭代指针指向的元素
     * @return the current storage entry
     */
    public function current() {
        return current($this->storage);
    }

    /**
     * 迭代指针指向下一元素
     */
    public function next() {
        next($this->storage);
        $this->index++;
    }

    /**
     * 容器中的对象数量
     * @return the number of objects in storage
     */
    public function count() {
        return count($this->storage);
    }

    /**
     * 以数组方式向容器添加对象，对象作为key，关联信息作为value
     */
    public function offsetSet($obj, $inf) {
        $this->attach($obj, $inf);
    }

    /**
     * 以数组方式从容器取得对象的关联信息
     * @return the data associated with an object
     */
    public function offsetGet($obj) {
        if (is_object($obj)) {
            if (isset($this->storage[$this->getHash($obj)])) {
                return $this->storage[$this->getHash($obj)][1];
            }
        }
        return false;
    }  

    /**
     * 以数组方式从容器移除对象
     */
    public function offsetUnset($obj) {
        $this->detach($obj);
    }

    /**
     * 以数组方式判断对象是否存在
     * @return bool
     */
    public function offsetExists($obj) {
        return $this->contains($obj);
    }

    /**
     * 序列化容器对象并返回
     * @return a string representation of the storage
     */
    public function serialize() {
        return serialize($this->storage);
    }

    /**
     * 反序列化容器对象并返回
     * @return a string representation of the storage
     */
    public function unserialize($storage) {
        $this->storage = unserialize($storage);
    }

    /**
     * 返回当前容器对象的关联信息
     * @return  the data associated with the current iterator entry
     */
    public function getInfo() {
        $element = current($this->storage);
        return $element ? $element[1] : NULL;
    }
    
    /**
     * 设置当前容器对象的关联信息
     */
    public function setInfo($inf = NULL) {
        if ($this->valid()) {
            $this->storage[key($this->storage)][1] = $inf;
        }
    }
    
    /**
     * 判断容器中是否存在该对象
     * @return bool
     */
    public function contains($obj) {
        if (is_object($obj)) {
            if (isset($this->storage[$this->getHash($obj)])) {
                return true;
            }
        }
        return false;
    }

    /** 
     * 往容器添加一个对象并设置关联信息
     */
    public function attach($obj, $inf = NULL) {
        if (is_object($obj) && !$this->contains($obj)) {
            $this->storage[$this->getHash($obj)] = array($obj, $inf);
        }
    }

    /** 
     * 删除容器中的对象
     */
    public function detach($obj) {
        if (is_object($obj)) {
            if (isset($this->storage[$this->getHash($obj)])) {
                unset($this->storage[$this->getHash($obj)]);
                $this->rewind();
                return;
            }
        }
    }

    /** 
     * 返回容器对象的哈希值
     * @return a string with the calculated identifier
     */
    public function getHash($obj) {
        return spl_object_hash($obj);
    }

    /** 
     * 将目标容器的对象添加到当前的容器
     */
    public function addAll(ObjectStorage $storage) {
        if (is_object($storage)) {
            $storage->rewind();
            while($storage->valid()) {
                $element = $storage->current();
                $this->attach($element[0], $element[1]);
                $storage->next();
            }
        }
    }

    /** 
     * 将目标容器的对象从当前的容器中删除
     */
    public function removeAll(ObjectStorage $storage) {
        if (is_object($storage)) {
            $storage->rewind();
            while($storage->valid()) {
                $element = $storage->current();
                if ($this->contains($element[0])) {
                    $this->detach($element[0]);
                }
                $storage->next();
            }
        }
    }

    /** 
     * 删除当前容器中不存在于目标容器中的对象
     */
    public function removeAllExcept(ObjectStorage $storage) {
        if (is_object($storage)) {
            $this->rewind();
            foreach($this->storage as $idx => $element) {
                if ($storage->contains($element[0])) {
                    continue;
                }
                unset($this->storage[$idx]);
            }
        }
    }
}

?>

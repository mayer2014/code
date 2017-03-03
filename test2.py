#!/usr/bin/env python3
# -*- coding: utf-8 -*-

' a test file '

__author__ = 'Mayer'

if __name__!='__main__':
    print('die')

start = USER = 'mayer'
#start = input('name:')
#if start != USER:
#    print('用户名错误！')
#    exit()

# str and num
print('\nstr and num:')
print(r"hello,%s! I'm python" % start)
print('10/3 =',10/3)
print('10//3 =',10//3)
print(0x001a)
print(bin(5))

# charset
print('\ncharset:')
print('\u4e2d\u6587'.encode('utf-8').decode('utf-8'))

#list and tuple
print('\nlist and tuple:')
my_tuple=(0,[1,5,3],(5),(6,))
my_list=my_tuple[1]
my_list.append(4)
my_list.insert(1,2)
my_list.pop(2)
my_list.sort()
print(my_tuple)

# dict and set
print('\ndict and set:')
my_dict={'b':2}
my_dict['a']=1
my_dict[('d',)]=2
my_dict.pop('b')
print(my_dict)
print('c' in my_dict)
print(my_dict.get('c',-1))
my_set=set([(2,),1,1,0])
my_set.add(3)
print(my_set)
my_set.remove(0)
print(my_set)

# if and for
print('\nif and for:')
apple=None
egg=None
if egg is apple:
    print('is None')
elif egg == apple:
    print('is ===')
else:
    print('is not')
print(range(101))
sum = 0
for x in list(range(101)):
    sum = sum + x
print(sum)
sum = 0
for x in range(101):
    sum = sum + x
print(sum)

# 内置函数
print('\n内置函数:')

# 定义函数
print('\n定义函数:')
def my_abs(x):
    if not isinstance(x, (int, float)):
        raise TypeError('bad operand type')
    if x >= 0:
        return x,x+1
    else:
        return -x

ret = my_abs(5)
print(ret)
ret1,ret2 = my_abs(6)
print(ret1)

# 函数参数
print('\n函数参数:')
def f1(a, b, c=0, *args, **kw):
    print('a =', a, 'b =', b, 'c =', c, 'args =', args, 'kw =', kw)

def f2(a, b, c=0, *, d, **kw):
    print('a =', a, 'b =', b, 'c =', c, 'd =', d, 'kw =', kw)

f1(1, 2, 3, 'a', 'b', x=99)
f2(1, 2, d=99, ext=None)
args = (1, 2, 3, 4)
kw = {'d': 99, 'x': '#'}
f1(*args, **kw)

# 递归
print('\n递归:')
def fact(n):
    return fact_iter(n, 1)
def fact_iter(num, product):
    if num == 1:
        return product
    return fact_iter(num - 1, num * product)

# 切片
print('\n切片:')
print(list(range(20))[::5])
print((1,2,3,4)[:2])
print('ABCDEFG'[-3:])

# 迭代
print('\n迭代:')
d = {'a': 1, 'b': 2, 'c': 3}
for k, v in d.items():
    print(k,v)
for i, v in enumerate(['A', 'B', 'C']):
    print(i,v)

# 列表生成式
print('\n列表生成式:')
print([x * x for x in range(1, 11) if x % 2 == 0])
print([m + n for m in 'ABC' for n in 'XYZ'])

# generator
print('\ngenerator:')
g = (x * x for x in range(10))
print(next(g))
for i in g:
    print(i)

def fib(max):
    n, a, b = 0, 0, 1
    while n < max:
        yield b
        a, b = b, a + b
        n = n + 1
    return 'done'
f=fib(6)
print(next(f))
print(next(f))

def h():
    print ('Wen Chuan')
    m = yield 5  # Fighting!
    print (m)
    d = yield 12
    print ('We are together!')
c = h()
m = next(c)  #m 获取了yield 5 的参数值 5
d = c.send('Fighting!')  #d 获取了yield 12 的参数值12
print ('We will never forget the date %d-%d'% (m,d))

# Iterator
print('\nIterator:')
from collections import Iterator
print(isinstance(iter('abc'), Iterator))

# 高阶函数
print('\n高阶函数:')
def add(x, y, f):
    return f(x) + f(y)
f=abs
print(add(-5,5,f))

# map/reduce
print('\nmap/reduce:')
print(list(map(str, [1, 2, 3, 4, 5, 6, 7, 8, 9])))
from functools import reduce
def char2num(s):
    return {'0': 0, '1': 1, '2': 2, '3': 3, '4': 4, '5': 5, '6': 6, '7': 7, '8': 8, '9': 9}[s]
def str2int(s):
    return reduce(lambda x, y: x * 10 + y, map(char2num, s))
print(str2int('99'))

# filter
print('\nfilter:')
def _odd_iter():
    n = 1
    while True:
        n = n + 2
        yield n
def _not_divisible(n):
    return lambda x: x % n > 0
def primes():
    yield 2
    it = _odd_iter()
    while True:
        n = next(it)
        yield n
        it = filter(_not_divisible(n), it)
for n in primes():
    if n < 50:
        print(n)
    else:
        break

# sorted
print('\nsorted:')
print(sorted(['bob', 'about', 'Zoo', 'Credit'], key=str.lower, reverse=True))

# Closure
print('\nClosure:')
def count():
    fs = []
    for i in range(1, 4):
        def f():
             return i*i
        fs.append(f)
    return fs
f1, f2, f3 = count()
print(f1(),f2(),f3())

# decorator
print('\ndecorator:')
import functools
def log(text):
    def decorator(func):
        @functools.wraps(func)
        def wrapper(*args, **kw):
            print('%s %s():' % (text, func.__name__))
            return func(*args, **kw)
        return wrapper
    return decorator
@log('excute')
def now(s):
    print(s)
now('2017-3-3')

# partial function
print('\n偏函数:')
import functools
int2 = functools.partial(int, base=2)
print(int2('10110'))

# 包模块
print('\n包模块:')
from PIL import Image
import sys
sys.path.append('/data/src/py')
print(sys.path)

# 类
print('\n类:')
class Student(object):
    an='110'
    def __init__(self, name, score):
        self._name = name
        self.__score = score
        self.test = 'test'

    def print_score(self):
        print('%s: %s' % (self._name, self.__score))
bart = Student('Bart Simpson', 59)
bart.print_score()
print(bart._Student__score)
bart.__score=60
print(bart.__score)
bart.print_score()
print(type('abc')==str)
import types
def fn():
    pass
print(type(fn)==types.FunctionType)
print(type(lambda x: x)==types.LambdaType)
print(type(abs)==types.BuiltinFunctionType)
print(type((x for x in range(10)))==types.GeneratorType)
print(isinstance(bart, Student))
print(isinstance(fn,types.FunctionType))
print(isinstance(b'a', bytes))
print(isinstance([1, 2, 3], (list, tuple)))
print(hasattr(bart, 'test'))
print(getattr(bart, 'y',404))
print(setattr(bart, 'y', 19))
print(getattr(bart, 'y'))
print(hasattr(bart, '_name'))
bart.app='112'
print(getattr(bart, 'app'))
print(getattr(bart, 'an'))

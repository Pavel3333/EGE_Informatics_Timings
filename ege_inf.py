#������ ��� �������� ����� ��������� ��� ������� ��������� ���  � ����������� �� � �������������� ����������. �������������� ������ � ���������� �� ���������� (����������� ������) � �����������.

#�������������� ��� ������� ������ ����� ������ ����� (1-23 �������), ��� � ������ ������� �������� (1-27).
#��� ������ ������������ �� ���� ������ � ������������ � ��.

#����� - ����� ����� aka Pavel3333

from time import time
from urllib import urlopen, urlencode

def checkAnswer(text):
    if raw_input(text + ' ��/���\n').lower() == '��': return True
    else:                                             return False

timing_eth = xrange(1, 28)

time_0 = 0
time_1 = 0
time_2 = 0

need_part_2 = False

my_timing = {}

if checkAnswer('������ ������ �����?'):
    need_part_2 = True
    
time_1 = time_0 = time()

length = 27 if need_part_2 else 23

while len(my_timing) < length:
    task = '0'
    while int(task) not in timing_eth:
        task = raw_input('������� ����� �������: ')
    time_2 = time()
    my_timing[task] = round((time_2 - time_1)/60, 2)
    time_1 = time_2

if not need_part_2:
    for i in xrange(24, 28):
        i_s = str(i)
        if i_s not in my_timing:
            my_timing[i_s] = 0.0

my_timing['type']        = 'inf'
my_timing['need_part_2'] = 1 if need_part_2 else 0
my_timing['total']       = (time_2 - time_0)/60


#�������� ���� URL ������� ege.php �� ����� �������
print urlopen('http://example.com/ege.php?' + urlencode(my_timing)).read()
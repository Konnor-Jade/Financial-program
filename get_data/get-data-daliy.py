
#引入所需要的库
import pandas as pd
#tushare 用于金融数据的获取
import tushare as ts
#引用延时函数
import time
import datetime
import numpy as np
from sqlalchemy import create_engine 
import sqlalchemy
import datetime

# 初始化数据库连接，使用pymysql模块
# MySQL的用户：finance, 密码:finance, 端口：3306,数据库：finance
engine = create_engine("mysql+mysqlconnector://finance:finance@localhost/finance?charset=utf8", echo=False)

#获取今日日期字符串
today = datetime.datetime.strftime(datetime.datetime.now(),'%Y%m%d') 
today

def save_to_index_basic(data,table_name,con,if_exists='append'):
    '''
    将数据存储入数据库
    data:存储的数据
    table_name: 要存储到的表名
    if_exists: 添加数据的方式，追加或者替换
    '''
    #将数据添加到数据库中时，index
    data.to_sql(name=table_name, con=engine, if_exists=if_exists,index=False)
    return ''


def get_today_index_basic(code,pro,today = today):
    '''
    利用tushare包获取基金基本数据
    code:需要获取历史数据的指数代码
    pro: tushare接口
    '''
    #data = pro.stock_basic(exchange='', list_status='L', fields='ts_code,symbol,name,area,industry,list_date')
    df = pro.index_dailybasic(ts_code = code,trade_date=today,fields='ts_code,trade_date,pe,pe_ttm,pb')
    return df

def get_today_sort(df_today,code,name):
    '''
    这个函数用于计算今日大盘pe值的历史百分位
    df_today:今日大盘指数数据
    code: 大盘指数代码
    name: 指数名称
    return :返回添加名称以及pe历史百分位的今日数据
    '''
    df_today.insert(1,'name',name)#把指数的简称插入df中
    df_today.insert(6,'sort',0)#为今日数据添加sort列，为后面计算排名做准备
    #定义查询语句
    sql_cmd = "SELECT * FROM index_basic WHERE ts_code LIKE '{0}'".format(code)
    #查询数据库中的上证指数的历史数据,存入df中
    df = pd.read_sql(sql=sql_cmd, con=engine)
    #将今日数据与历史数据合并为一个dataframe对象，准备计算sort
    df = df.append(df_today)
    df = df.sort_values('pe')#按照pe值排序
    df = df.reset_index(drop = True)#重置index,丢掉原有的index
    df.loc[:,'sort']= df.index/df.count()['pe']#计算每一天的分位值,保存为4位小数
    df['sort'] = df['sort'].round(4)
    #取得今日的数据
    df_today = df.loc[df['trade_date']==today]
    返回今日数据
    return df_today



def main():
   #初始化pro接口
   token='dcbba363ca8de7425e2cafe1ceb202c6d4101bed47984e92a4c5b679'
   ts.set_token(token)
   pro=ts.pro_api()

   #指数列表
   index_list = {'上证指数':'000001.SH','商业指数':'000005.SH',\
   '地产指数':'000006.SH','上证50':'000016.SH',\
   '沪深300':'000300.SH','中证500':'000905.SH',\
    '深证成指':'399001.SZ','中小板指':'399005.SZ',\
    '创业板指':'399006.SZ ','深证创新':'399016.SZ'}


   today = datetime.datetime.strftime(datetime.datetime.now(),'%Y%m%d') 
   today

   for name,code in index_list.items():
       df_today = get_today_index_basic(code = code, pro = pro)#获取代码为code的指数的今日数据
       df_today = get_today_sort(df_today = df_today,code=code,name = name)
       save_to_index_basic(data = df,con = engine, table_name='index_basic',if_exists='append')
       #用延时函数延迟1s运行，防止对tushare服务器访问频度过快，加重服务器负担
       time.sleep(1)


main()

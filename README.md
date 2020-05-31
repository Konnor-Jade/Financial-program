# Financial-program

金融分析小程序后台代码以及接口使用帮助

## 接口文件使用简介

### 一、获取特定大盘数据 

- 链接：https://www.finance-data.keytoheart.top/data-name.php

- 方法：GET

- 参数：name：指大盘指数的简称，可获取数据的大盘列表如下

  - 上证指数: 000001.SH
  - 商业指数: 000005.SH
  - 地产指数: 000006.SH
  - 上证50: 000016.SH
  - 沪深300: 000300.SH
  - 中证500: 000905.SH
  - 深证成指: 399001.SZ
  - 中小板指: 399005.SZ
  - 创业板指: 399006.SZ,
  - 深证创新: 399016.SZ
  
- 返回参数列表：name - code - trade_date - pe - sort

  - 表示大盘简称 - 大盘代码 - 交易日期 - 当日市盈率 - 历史市盈率百分位

- 使用方法：

  - 浏览器：

    ```
    https://www.finance-data.keytoheart.top/data-name.php?name=名称
    ```

    例如：

    ```
    https://www.finance-data.keytoheart.top/data-name.php?name=上证指数
    ```

    大盘名称列表见上文

### 二、获取某一日所有大盘指数信息

- 链接：https://www.finance-data.keytoheart.top/data-daliy.php

- 方法：GET

- 参数：day：指日期字符串

  - 日期必须是字符串 格式为 YYYYMMDD
  - 日期必须是开市日，除开节假日外，我国开市日为每周一至周五

- 返回参数列表：name - code - trade_date - pe - sort

  - 表示大盘简称 - 大盘代码 - 交易日期 - 当日市盈率 - 历史市盈率百分位

- 使用方法：

  - 浏览器：

    ```
    https://www.finance-data.keytoheart.top/data-daliy.php?day=日期
    ```

    例如：

    ```
    https://www.finance-data.keytoheart.top/data-daliy.php?day=20200430
    ```

    
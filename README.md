###  BorderCollie: AI-Powered Furry Gathering Aggregation System  
**Developed by Shoutime BBS | Powered by DeepSeek & AMap**  
[![SI Logo](https://media.shoutime.cn/more/SIlogo.png)](https://api.shoutime.net/BorderCollie)

---

#### 🌟 Project Overview  
**BorderCollie** is an open-source furry gathering aggregation system designed for the furry community. Built on DeepSeek technology, it intelligently integrates geolocation data with event databases to help furries quickly discover and participate in nearby offline gatherings, solving traditional platforms' efficiency bottlenecks when handling massive data.

---

#### 🔍 Core Features  
- **Precision Location Discovery**  
  Uses AMap to obtain user locations, automatically scans for nearby furry gatherings, and visually presents event details  
- **Efficient Data Integration**  
  Proprietary distributed processing logic overcomes DeepSeek's data limitations in big-data scenarios while conserving tokens  
- **User-Friendly Experience**  
  Clean interface + multi-dimensional info display (time/location/event type) + conversational output  

---

#### ⚙️ Tech Stack  
```bash
Core Language: PHP  
Runtime Environment: PHP8.1 + MySQL5.7.44 + Apache2.4.62
(Versions used in community deployment - reference only)  
```

---

#### 🚀 Deployment  
```bash
git clone [repo] → Place BorderCollie contents in root directory
Configure PHP+MySQL → Import database → Launch service
Modify the following:
```

1. In `index.php`:
```php
src="https://webapi.amap.com/maps?v=1.4.15&key=YOUR_AMAP_API_KEY&plugin=AMap.Geolocation,AMap.Geocoder">
```
```php
window._AMapSecurityConfig = {
    securityJsCode: "YOUR_AMAP_SECURITY_CODE" 
};
```

2. In `message.php`:
```php
$servername = "";
$username = "";  // DB username
$password = "";  // DB password
$dbname = "";    // DB name
```
> *Logs user outputs/IPs for monitoring, error tracking, and abuse prevention*

3. In `getCity.php`:
```php
$servername = ""; // DB server
$username = "";   // DB username
$password = "";   // DB password
$dbname = "";     // DB name
```

4. In `city.php`:
```php
$apiKey = 'YOUR_DEEPSEEK_API'; 
```

5. In `getLocation.php`:
```php
<script src="https://webapi.amap.com/maps?v=1.4.15&key=YOUR_AMAP_API&plugin=AMap.Geolocation,AMap.Geocoder"></script>
```
```php
window._AMapSecurityConfig = {
    securityJsCode: "YOUR_AMAP_SECURITY_CODE" 
};
```

6. In `output.php`:
```php
$apiKey = 'YOUR_DEEPSEEK_API'; 
```
Modify prompt to:
```php
"Use <p> for paragraphs, <strong> for emphasis, HTML/CSS for coloring/styling, <br> for line breaks. Add hyperlinks to gathering names: 'https://yourdomain.com/events/' + id with target='_blank'"
```

7. In `getInfo.php`:
```php
$servername = ""; // DB server
$username = "";   // DB username
$password = "";   // DB password
$dbname = "";     // DB name
```

8. Update BeastTime-related references in `index.php`

---

#### 🌐 Direct Access  
[Live Demo](https://bc.shoutime.net)  
(Real-time sync with BeastTime Community gathering database)

---

#### 🌍 Open-Source Vision  
> BeastTime invites organizations/individuals with furry gathering data to integrate with this system, building the **world's most comprehensive furry event network**. Through open-source, we ensure every gathering is discoverable.

---

### 📜 Copyright Statement  
© 2025 Shoutime.net | Apache 2.0 License  
**Brand assets (BorderCollie/SIlogo) remain proprietary** - compliant use/derivative works welcome!



---
---


###  BorderCollie 人工智能兽聚聚合系统
---
**由兽时社区（Shoutime BBS）开发 | 基于 DeepSeek 、高德地图**  
[![SI Logo](https://media.shoutime.cn/more/SIlogo.png)](https://api.shoutime.net/BorderCollie)
#### 项目简介  
**BorderCollie** 是一款专为Furry社群设计的开源兽聚聚合系统。它基于 DeepSeek 技术构建，通过智能整合地理位置与兽聚数据库，帮助Furry们快速发现并参与周边的线下兽聚活动，解决传统平台面对海量数据时的效率瓶颈。
#### 核心功能  
- **精准定位发现**  
  通过高德地图获取用户位置，自动扫描附近城市的兽聚信息，可视化呈现活动详情  
- **数据高效整合**  
  独创的分布式处理逻辑，突破 DeepSeek 在大数据场景下的数据限制同时可以节省token
- **人性化体验**  
  简洁美观的界面 + 多维度信息展示（时间/地点/活动类型）+ 沟通的方式输出信息

  
  ---
  
#### ⚙️ 系统  
```bash
核心语言：PHP  
运行环境：PHP8.1 + MySQL5.7.44 + Apache2.4.62
（社区部署使用的版本，供参考，不强制）  
```
---

#### 🚀 部署  
   git clone [项目仓库]，将BorderCollie文件夹的内容放在根目录
   配置 PHP+MySQL 环境 → 导入数据库 → 启动服务
   修改以下代码：
   1.修改index.php中的
   ```php
  src="https://webapi.amap.com/maps?v=1.4.15&key=这里输入你的高德地图API&plugin=AMap.Geolocation,AMap.Geocoder">
```

```php
        window._AMapSecurityConfig = {
            securityJsCode: "这里修改为你的高德地图securityCode" 
        };
   ```
2.修改message.php中的
```php
$servername = "";
$username = "";  // 你的数据库用户名
$password = "";  // 你的数据库密码
$dbname = "";  // 你的数据库名称
```
**这个文件用于将用户得到的输出信息和IP地址写入到数据库，可以用于判断系统是否正常工作（也会写入BorderCollie的报错信息）同时也可以通过IP信息防止被用户恶意使用**


3.修改getCity.php中的~~（因为我最开始写的比较乱，所以很多功能写重了，但是不想修改了）~~
```php
$servername = ""; // 数据库服务器
$username = ""; // 数据库用户名
$password = ""; // 数据库密码
$dbname = ""; // 数据库名
```
4.修改city.php中的
```php
$apiKey = '这里输入DeepSeekAPI'; 
```
5.修改getLocation.php中的
```php
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=你的高德地图api&plugin=AMap.Geolocation,AMap.Geocoder"></script>
```
```php
        window._AMapSecurityConfig = {
            securityJsCode: "这里修改为你的高德地图securityCode" 
        };
   ```
5.修改output.php中的
```php
$apiKey = 'DeepSeekAPI'; 
```
修改
```php
适当使用<p>来进行分段，使用<strong>进行强调，使用html语句和内嵌css来为内容添加颜色、标记重要信息\让它变得更好看更有色彩，使用包括<br>等标签来美化返回结果,同时给兽聚的名字加上超链接，位置是“https://www.shoutime.net/events/+id”，加上target=“_blank“" 
```
的提示词网址，使其可以适配你的网站

6.修改getInfo.php中的
```php
$servername = ""; // 数据库服务器
$username = ""; // 数据库用户名
$password = ""; // 数据库密码
$dbname = ""; // 数据库名
```
7.修改index.php中的其他与兽时社区相关的信息
   

**直接体验**  
   [点击进入在线版](https://bc.shoutime.net)  
   （实时同步兽时社区官方兽聚数据库）
   
   ---
   
#### 开源愿景  
> 兽时社区诚邀拥有兽聚数据的组织/个人接入此系统，共同打造**全球最全面的兽聚信息网络**。通过开源，让每一场兽聚都能被精准发现。

---

### 版权声明  
© 2025 Shoutime.net | Apache 2.0 开源协议  
**我们保留品牌标识（BorderCollie/SIlogo）的所有权**，欢迎合规使用与二次开发！


<!DOCTYPE html>
<html lang="zh_CN" >
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <title>兽时边牧Beta</title>
  <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        #loading { display: none; }
        .start_button button {
            display: none;
            border: 1.5px solid white;
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            color: white; /* 默认文字颜色 */
            transition: background-color 0.3s ease, color 0.3s ease; /* 添加过渡效果 */
        
        }
        
        .start_button button:hover {
            background-color: white;
            color: #4C4EB5;
        }

    </style>
</head>
<body>
    <!--获取用户位置-->
        <script type="text/javascript">
        window._AMapSecurityConfig = {
            securityJsCode: "这里修改为你的高德地图securityCode" 
        };
    </script>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=这里输入你的高德地图API&plugin=AMap.Geolocation,AMap.Geocoder"></script>
</head>
<body>
    <script type="text/javascript">
    var city=""
        // 初始化地图对象
        var map = new AMap.Map('container', {
            resizeEnable: true
        });

        // 加载Geolocation插件
        AMap.plugin('AMap.Geolocation', function() {
            var geolocation = new AMap.Geolocation({
                enableHighAccuracy: true, // 是否使用高精度定位，默认：true
                timeout: 10000,           // 超过10秒后停止定位，默认：无穷大
                maximumAge: 0,            // 定位结果缓存0毫秒，默认：0
                convert: true,            // 自动偏移坐标，偏移后的坐标为高德坐标，默认：true
                showMarker: false,        // 定位成功后在定位到的位置显示点标记，默认：true
                showCircle: false,        // 定位成功后用圆圈表示定位精度范围，默认：true
                panToLocation: true,      // 定位成功后将定位到的位置作为地图中心点，默认：true
                zoomToAccuracy: true      // 定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
            });

            map.addControl(geolocation);
            geolocation.getCurrentPosition(function(status, result) {
                if (status === 'complete') {
                    onComplete(result);
                } else {
                    onError(result);
                }
            });
        });

        function onComplete(data) {
            var position = data.position;
            var lngLat = [position.getLng(), position.getLat()];

            // 使用Geocoder插件解析地址
            AMap.plugin('AMap.Geocoder', function() {
                var geocoder = new AMap.Geocoder();
                geocoder.getAddress(lngLat, function(status, result) {
                    if (status === 'complete' && result.regeocode) {
                        var addressComponent = result.regeocode.addressComponent;
                        var city = addressComponent.city || addressComponent.province;
                        // 去掉城市名称末尾的“市”字
                        if (city.endsWith('市')) {
                            city = city.slice(0, -1);
                        }
                        document.getElementById('result').innerHTML = "您当前所在城市：" + city;
                        window.city = city; // 设置为全局变量
                        // 显示按钮
                        const buttons = document.querySelectorAll('.start_button button');
                            buttons.forEach(button => {
                                button.style.display = 'inline-block'; 
                            });
                    } else {
                        document.getElementById('result').innerHTML = "无法获取城市信息";
                    }
                });
            });
        }

        // 定位失败回调
function onError(errorData) { 
    var str = '定位失败啦！<br>可能是设备没有开启GPS或没有允许我获取你的定位哦！';
    str += '<br>错误：' + errorData.message; 

    fetch('https://ipwhois.app/json/')
        .then(response => response.json())
        .then(ipData => { 
            const ip = ipData.ip; 
            console.log('用户的IP地址是：', ip); 

            $.post('message.php', { 
                location: '定位失败',  
                message: errorData.message,
                ip: ip
            }, function(response) {
                console.log("服务器返回:", response); 
                if (response.error) {
                    $('#result').append('<p style="color:red;">错误: ' + response.error + '</p>');
                } else {
                }
            }, 'json').fail(function(xhr, status, error) {
                console.error("请求失败:", error);
            });

            document.getElementById('result').innerHTML = str;
        })
        .catch(error => {
            console.error('获取IP地址时发生错误:', error);
            $('#result').append('<p style="color:red;">获取IP失败: ' + error + '</p>');
        });
}

    </script>
    
    
    
<div class="card">
  <svg 
       viewBox="0 0 100% 100%"
       xmlns='http://www.w3.org/2000/svg'
       class="noise"
       >
    <filter id='noiseFilter'>
      <feTurbulence 
                    type='fractalNoise' 
                    baseFrequency='0.85' 
                    numOctaves='6' 
                    stitchTiles='stitch' />
    </filter>

    <rect
          width='100%'
          height='100%'
          preserveAspectRatio="xMidYMid meet"
          filter='url(#noiseFilter)' />
  </svg>
<h1>
  <span><img style="width:70%;" src="https://media.shoutime.cn/more/SIlogo.png"></span>
</h1>
  <div class="content">
      <div id="result">正在获取您的位置信息...</div>
      <div id="result" style="font-size:13px; margin-top:15px; color:#ffffff66;">"兽时边牧"目前版本V0.8Beta，是"<a style="color:#ffffff9c;" href="https://www.shoutime.net" target="_blank">兽时社区</a>"的免费功能</br>最新兽聚数据更新于2025/3/8, 共收录658条兽聚信息</br>此功能需要您的定位来判断您的物理位置。</div>
      <div class="start_button">
     <button class="start" id="start">开始探索吧&nbsp;>></button></div>
    <div id="result"></div>

    <script>
        $(document).ready(function() {
            $('#start').click(function() {
                $(this).hide();
                $('#loading').show();
                  $('#loading').show();
                  // 显示第一个等待消息及 Lottie 动画
                  $('#result').html(
                    '<img src="s.png" style="width:18px;">&nbsp;&nbsp;正在嗅嗅附近城市的气息，请稍等一下...<br>' +
                    '<lottie-player src="loading.json" ' +
                    'background="transparent" speed="1" style="width: 80px; height: 80px;" loop autoplay>' +
                    '</lottie-player>'
                  );
                
                $.post('city.php', { city: window.city }, function(cityData) {
                    if (cityData.error) {
                        $('#result').html('<p>🚨 发生错误：' + cityData.error + '</p>');
                        $.post('message.php', { 
                        location: '发生错误',  
                        message: '发生错误', 
                        ip: ip 
                    }, function(response) {
                        if (response.error) {
                        } else {
                        }
            }, 'json').fail(function(xhr, status, error) {
                console.error("请求失败:", error);
                
            });
                            console.log("postdata：", window.city);
                            console.log("backdata：", cityData)
                        $('#loading').hide();
                        return;
                    }
                    $('#result').html('<img src="ok.png" style="width:18px;padding-top:5px;">&nbsp;&nbsp;<strong>658</strong>条兽聚信息' + cityData.cities.join('、') + '<br><img src="logo.png" style="width:18px;padding-top:5px;">&nbsp;&nbsp;请给我一些时间让我搜索整理一下这些活动的详细信息...' +
                    '<lottie-player src="loading.json" ' +
                    'background="transparent" speed="1" style="width: 80px; height: 80px;" loop autoplay>' +
                    '</lottie-player>'
                    );
                    $.post('output.php', { cities: cityData.cities }, function(outputData) {
                        $('#loading').hide();
                        $('#result').html(outputData);
                        // 输出
                        
                        $.post('message.php', { location: window.city, message: outputData, ip:'c' });
                    });
                }, 'json');
            });
        });
    </script>
  </div>
  
</div>
<div class="gradient-bg">
  <svg 
       viewBox="0 0 100vw 100vw"
       xmlns='http://www.w3.org/2000/svg'
       class="noiseBg"
       >
    <filter id='noiseFilterBg'>
      <feTurbulence 
                    type='fractalNoise'
                    baseFrequency='0.6'
                    stitchTiles='stitch' />
    </filter>

    <rect
          width='100%'
          height='100%'
          preserveAspectRatio="xMidYMid meet"
          filter='url(#noiseFilterBg)' />
  </svg>
  <svg xmlns="http://www.w3.org/2000/svg" class="svgBlur">
    <defs>
      <filter id="goo">
        <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8" result="goo" />
        <feBlend in="SourceGraphic" in2="goo" />
      </filter>
    </defs>
  </svg>
  <div class="gradients-container">
    <div class="g1"></div>
    <div class="g2"></div>
    <div class="g3"></div>
    <div class="g4"></div>
    <div class="g5"></div>
    <div class="interactive"></div>
  </div>
</div>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>

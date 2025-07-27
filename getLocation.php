<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>高德地图定位</title>
    <script type="text/javascript">
        window._AMapSecurityConfig = {
            securityJsCode: "这里修改为你的高德地图securityCode" 
        };
    </script>
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=你的高德地图api&plugin=AMap.Geolocation,AMap.Geocoder"></script>
</head>
<body>
    <div id="result">正在获取您的位置信息...</div>
    <script type="text/javascript">
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
                    } else {
                        document.getElementById('result').innerHTML = "无法获取城市信息";
                    }
                });
            });
        }

        // 定位失败回调
        function onError(data) {
            var str = '定位失败！';
            str += '<br>错误信息：' + data.message;
            document.getElementById('result').innerHTML = str;
        }
    </script>
</body>
</html>

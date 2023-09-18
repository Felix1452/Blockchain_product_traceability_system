<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        /*div#bigBox {width:600px; height:300px; border:1px solid black; text-align:center; }*/

        .bg {
            position: relative;
            /* The image used */
            {{--background-image: url("{{ $img }}");--}}

            background-image: url({{url('storage/img/cyber.png')}});
            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            /*text-align: center;*/
            /*margin-bottom: 200px;*/
        }
        #bigBox{
            position:absolute;
            margin-top: 200px;
            margin-left: 900px;
        }

        #bigBox1{
            position:absolute;
            margin-top: 300px;
            margin-left: 900px;
        }
        .glow-on-hover {
            width: 220px;
            height: 50px;
            border: none;
            outline: none;
            color: #fff;
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
        }

        .glow-on-hover:before {
            content: '';
            background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            position: absolute;
            top: -2px;
            left:-2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing 20s linear infinite;
            opacity: 0;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
        }

        .glow-on-hover:active {
            color: #000
        }

        .glow-on-hover:active:after {
            background: transparent;
        }

        .glow-on-hover:hover:before {
            opacity: 1;
        }

        .glow-on-hover:after {
            z-index: -1;
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: #111;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        @keyframes glowing {
            0% { background-position: 0 0; }
            50% { background-position: 400% 0; }
            100% { background-position: 0 0; }
        }

        #buttonP{
            position:absolute;
            margin-top: 400px;
            margin-left: 950px;
        }


    </style>
</head>
<body>

<div class="bg">
    <div id="bigBox"><h1 style="color: white">HỆ THỐNG AN TOÀN!</h1></div>
    <div id="bigBox1"><h2 style="color: white">Thời gian xác thực {{ (int)($time / 60) }} phút trước</h2></div>
    <div id="buttonP"><a href="/admin/"><button class="glow-on-hover" type="button">QUAY VỀ TRANG QUẢN TRỊ!</button></a></div>
</div>

</body>
</html>

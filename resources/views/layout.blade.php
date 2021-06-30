<html>
<head>
    <title>@yield('title', 'Laravel')</title>
</head>
<body>
    <ul>
<li><a href="/welcome">Welcome</a></li>               
        <li><a href="/contact">Contact</a></li>
        <li><a href="/hello">Hello</a></li>
    </ul>
    @yield('content')
</body>
</html>
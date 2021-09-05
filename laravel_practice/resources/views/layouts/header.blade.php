<div>
    <h1>header!!!</h1>
    <nav>
        <li>
            <a href="/" class="{{ request()->is('/') ? 'active' : ''}}">home</a>
        </li>
        <li>
            <a href="/about" class ="{{ request()->is('/about/*') ? 'active' : '' }}">about</a>
        </li>
        <li>
            <a href=""></a>
        </li>
    </nav>
</div>

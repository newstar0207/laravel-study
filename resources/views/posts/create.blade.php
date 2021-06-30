<html>
    <head>
        <style>  
            #create {
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head> 
    <body>
        <div id="create">
            <form action="/posts/store" method="post">
                @csrf
                <fieldset style="width:150">
                <legend>등록합니다</legend>
                제목 : <input type="text" name="title" /><br><br>
                내용 : <input type="text" name="content"/><br><br>
                <button type="submit">
            </fieldset>
        </form>  
        </div>
    </body>
</html>
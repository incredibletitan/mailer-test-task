<head>
    <script src="js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({selector: 'textarea'});</script>
</head>

<body>
<form enctype="multipart/form-data" method="POST">
    <label for="mailto">Send to</label> <br/>
    <input type="text" name="mailto" id="mailto"> <br/>
    <label for="title">Message title</label> <br/>
    <input type="text" name="title" id="" title""> <br/>
    <label for="body">Message text</label> <br/>
    <textarea name="body" id="body"></textarea> <br/>
    <label for="files">Attachments</label> <br/>
    <input name="files[]" type="file" id="files" multiple="multiple"/><br/><br/>
    <input name="sbn" type="submit" value="send"/>
</form>
</body>
<html>
<head></head>
<body>
<h1>Documents</h1>
<form action="/api/test/putS3" id="frm" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="uploadName" />
    <input type = "submit" value="upload" />
</form>
</body>
</html>

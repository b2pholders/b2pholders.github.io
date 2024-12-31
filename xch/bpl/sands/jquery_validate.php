<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JQuery Validation</title>
</head>
<body>
<form id="signupform" method="get" action="">
    <table>
        <tr>
            <td class="label">
                <label id="lfirstname" for="firstname">First Name</label>
            </td>
            <td class="field">
                <input id="firstname" name="firstname" type="text" value="" maxlength="100">
            </td>
            <td class="status"></td>
        </tr>
        <!-- more fields -->
    </table>
</form>
<script src="../plugins/jquery.min.js"></script>
<script src="../plugins/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signupform').validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                firstname: {
                    required: 'Name required',
                    minlength: 'Minimum of 2 characters'
                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent("td").next("td"));
            }
        });
    })
</script>
</body>
</html>

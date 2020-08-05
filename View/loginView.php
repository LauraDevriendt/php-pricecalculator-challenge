
<?php require 'includes/header.php' ;?>
<section class="container">
    <!--@todo write access to database?-->
    <h1 class="mt-5">Login</h1>
    <?php if (!empty($_POST['surname']) || !empty($_POST['password'])) echo "$errorLoginMessage";?>
    <form method="post" class="form-inline">
        <label class="sr-only" for="inlineFormInputName2">Name</label>
        <input type="text" name="surname" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Surname">

        <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">#</div>
            </div>
            <input type="password" name="password" class="form-control" id="inlineFormInputGroupUsername2" placeholder="password">
        </div>

        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>

</section>
<?php require 'includes/footer.php' ;?>
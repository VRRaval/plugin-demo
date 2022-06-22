<div class="container">
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign in here <small>It's free!</small></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo get_the_permalink(); ?>" method="post">
                        <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                        </div>
                        <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        </div>
                        <div class="checkbox">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                        </div>
                        <button type="submit" name="userLogin" class="btn btn-info btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
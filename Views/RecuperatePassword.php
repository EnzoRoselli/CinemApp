<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<div class="form-gap"></div>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="text-center">
            <h3><i class="fa fa-lock fa-4x"></i></h3>
            <h2 class="text-center">Introduce the code</h2>
            <p>Check in your email the code. Then introduce it here.</p>
            <div class="panel-body">
              <form action=<?= FRONT_ROOT . "/User/testRecuperation" ?> id="register-form" role="form" autocomplete="off" class="form" method="get">
                <div class="form-group">
                  <div class="input-group">
          
                 <input id="emailRecuperationCode" name="code" placeholder="RECUPERATION CODE" class="form-control" type="email" />
                  
                  </div>
                </div>
                <div class="form-group">
                  <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password"
                    type="submit" />
                </div>

                <input type="hidden" class="hide" name="token" id="token" value="" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
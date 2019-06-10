<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand main" href="dashboard.php"><?php echo lang('home'); ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav left">
        <li><a href="categories.php"><?php echo lang('section'); ?></a></li>
        <li><a href="items.php"><?php echo lang('items'); ?></a></li>
        <li><a href="member.php"><?php echo lang('members'); ?></a></li>
        <li><a href="comment.php"><?php echo lang('comment'); ?></a></li>
        <li><a href="../dashboard.php"><?php echo lang('live'); ?></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mohamed <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="member.php?do=edit&id=<?php echo $_SESSION['id']; ?>">Edit</a></li>
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

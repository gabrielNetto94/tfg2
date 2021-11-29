<nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse" data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Menu"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand mr-1 mr-sm-3" href="/tfg/">
        <div class="d-flex align-items-center">
            <img class="mr-2" src="/tfg/assets/img/BIRA.svg" width="80"/>
        </div>
    </a>
    <ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
        <li class="nav-item dropdown dropdown-on-hover">
            <span class="notification-indicator notification-indicator-warning notification-indicator-fill icon-indicator float-right fixed-top d-inline-block" style="margin-top: -3px; margin-right: -7px;">
                <span id="notifyNumber" class="notification-indicator-number font-weight-normal align-middle"></span>
            </span>
            <a class="nav-link pr-0" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div style="display: flex; align-items: center;">
                    <span style="padding-right: .5em"><?php echo "Usuário Teste"; ?></span>
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="/tfg/assets/img/avatar.png" alt="User"/>
                    </div>
                </div>
            </a>
            <!-- <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white rounded-soft py-2">
                    <div class="card card-notification shadow-none" style="max-width: 20rem">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h6 class="card-header-title">Novas notificações</h6>
                                </div>
                                <div class="col-auto mb-2">
                                    <a class="card-link font-weight-normal" href="/notifications/">Ver todas</a>
                                </div>
                            </div>
                        </div>
                        <div id="notifications" class="list-group list-group-flush font-weight-normal fs--1"></div>
                    </div>
                    <a class="dropdown-item text-right mt-2" href="/login/">Sair do BIRA <span class="ml-2 text-500 fas fa-sign-out-alt"></span></a>
                </div>
            </div> -->
        </li>
    </ul>
</nav>
<script>
    /*
    function checkNotify(check){
        $.get("/notifications/count-notify.php", function( data ) {
            if ($('#notifyNumber').html() !== data){
                $("#notifyNumber").text(data);
                $('#notifications').load('/notifications/notifications.php');
                if (check){
                    playAudio();
                    if ($('#messages').length){
                        location.reload();
                    }
                }
            }
        });
    }
    function playAudio(){
        var audio = new Audio('/assets/audio/newmessage.mp3');
        audio.play();
    }
    checkNotify(false);
    setInterval(function() {
        checkNotify(true);
    }, 10000);
    */
</script>
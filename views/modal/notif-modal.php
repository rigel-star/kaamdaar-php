<?php 
    require_once "../../constants.php";
    require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";
    require_once ROOT_DIR . "views/request-constants.php";
?>

<div class="modal notif-modal">
    <div class="notif-container">
        <div class="notif-nav">
            <span>
                Notifications
            </span>
            <img id="msg-icon" src="https://img.icons8.com/ios/344/chat-message--v1.png" alt="">
        </div>
        <div class="notif-list-container">
            <ul class="notif-list">
                <li class="notif">
                    <div class="notif-root unread">
                        <div class="notif-head">
                            <div class="notif-head-icon">
                                <img class="notif-head-icon-img" src="https://img.icons8.com/ios-filled/344/computer-support.png" alt="">
                            </div>
                            <div class="notif-head-title">
                                <p class="notif-profile">
                                    User wants
                                </p>
                                <p class="notif-title">
                                    Service
                                </p>
                            </div>
                        </div>
                        <div class="notif-body">
                            <p class="notif-desc">
                                This is description of notification.
                            </p>
                            <p class="notif-date">
                                Time
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="see-all">
            <a href="#">SEE ALL</a>
        </div>
    </div>
</div>
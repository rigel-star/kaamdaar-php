function updateNotifCount()
{
    let countContainer = document.getElementById("notif-count");
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = () => {
        if(xhr.readyState == XMLHttpRequest.DONE)
        {
            if(xhr.status == 200)
            {
                var count = JSON.parse(xhr.responseText)?.notif_count;
                if(!count || count == "0")
                    countContainer.style.display = "none";
                else 
                {
                    countContainer.style.display = "block";
                    countContainer.innerText = count;
                }
            }
        }
    }

    xhr.open("GET", "./modal/fetch-notifs.php?count=9999999999&action=count", true);
    xhr.send();

    setInterval(() => { 
        xhr.open("GET", "./modal/fetch-notifs.php?count=9999999999&action=count", true);
        xhr.send();
    }, 10000);
};
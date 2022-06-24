class Notification 
{
    constructor(icon, profile, title, description, date, requestId)
    {
        this.icon = icon;
        this.profile = profile;
        this.title = title;
        this.description = description;
        this.date = date;
        this.requestId = requestId;
    }

    createHTML()
    {
        let notifRoot = document.createElement("div");
        notifRoot.classList.add("notif-root", "notif-unread");

        let notifHead = document.createElement("div");
        notifHead.classList.add('notif-head');

        let notifHeadIcon = document.createElement("div");
        notifHeadIcon.classList.add('notif-head-icon');

        let notifHeadIconImg = document.createElement("img");
        notifHeadIconImg.classList.add('notif-head-icon-img');
        notifHeadIconImg.src = this.icon;

        let notifHeadTitle = document.createElement("div");
        notifHeadTitle.classList.add('notif-head-title');

        let notifProfile = document.createElement("p");
        notifProfile.classList.add('notif-profile');
        notifProfile.innerText = this.profile;

        let notifTitle = document.createElement("p");
        notifTitle.classList.add('notif-title');
        notifTitle.innerText = this.title;

        let notifBody = document.createElement("div");
        notifBody.classList.add('notif-body');

        let notifDesc = document.createElement("p");
        notifDesc.classList.add('notif-desc');
        notifDesc.innerText = this.description;

        let notifDate = document.createElement("p");
        notifDate.classList.add('notif-date');
        notifDate.innerText = this.date;

        notifHeadIcon.appendChild(notifHeadIconImg);
        notifHeadTitle.appendChild(notifProfile);
        notifHeadTitle.appendChild(notifTitle);
        notifHead.appendChild(notifHeadIcon);
        notifHead.appendChild(notifHeadTitle);

        notifBody.appendChild(notifDesc);
        notifBody.appendChild(notifDate);

        notifRoot.appendChild(notifHead);
        notifRoot.appendChild(notifBody);
        return notifRoot;
    }
}

class RequestNotification extends Notification
{
    constructor(icon, profile, title, description, date, requestId, userId)
    {
        super(icon, profile, title, description, date, requestId);
        this.userId = userId;
    }

    createHTML()
    {
        let notif = super.createHTML();
        let actionBar = document.createElement("div");
        actionBar.classList.add('notif-action-bar');

        let offer = document.createElement('button');
        offer.innerText = "Offer service";
        offer.classList.add('notif-btn', "notif-offer-btn");

        actionBar.appendChild(offer);
        notif.appendChild(actionBar);
        return notif;
    }
}

class ResponseNotification extends Notification
{
    constructor(icon, profile, title, description, date, requestId, type, status, sender)
    {
        super(icon, profile, title, description, date, requestId);
        this.responseType = type;
        this.responseStatus = status;
        this.senderId = sender;
    }

    createHTML()
    {
        let notif = super.createHTML();
        let actionBar = document.createElement("div");
        actionBar.classList.add('notif-action-bar');

        if(this.responseType === "business-response")
        {
            let viewDetails = document.createElement('button');
            viewDetails.innerText = "View details";
            viewDetails.classList.add('notif-btn', 'notif-view-details-btn');

            if(this.responseStatus == "0") // if response is interactable
                actionBar.appendChild(viewDetails);
        }
        else if(this.responseType === "user-response")
        {
            let accept = document.createElement("button");
            accept.innerText = "Accept";
            accept.classList.add('notif-btn', 'notif-accept-btn');

            let reject = document.createElement("button");
            reject.innerText = "Reject";
            reject.classList.add('notif-btn', 'notif-reject-btn');

            if(this.responseStatus == "0") // if response is interactable
            {
                actionBar.appendChild(reject);
                actionBar.appendChild(accept);
            }
        }

        notif.appendChild(actionBar);
        return notif;
    }
}
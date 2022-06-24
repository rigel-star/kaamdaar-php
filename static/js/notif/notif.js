class Notification 
{
    constructor(icon, profile, title, description, date)
    {
        this.icon = icon;
        this.profile = profile;
        this.title = title;
        this.description = description;
        this.date = date;
    }
}

class RequestNotification extends Notification
{
    constructor(icon, profile, title, description, date, requestId, userId)
    {
        super(icon, profile, title, description, date);
        this.requestId = requestId;
        this.userId = userId;
    }
}

class ResponseNotification extends Notification
{
    constructor(icon, profile, title, description, date, type, status, sender)
    {
        super(icon, profile, title, description, date);
        this.responseType = type;
        this.responseStatus = status;
        this.senderId = sender;
    }
}
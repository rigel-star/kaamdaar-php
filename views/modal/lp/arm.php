<style>
    .modal-body 
    {
        height: 300px;
    }

    .send-req-btn 
    {

    }
</style>

<div class="modal-content">
    <div class="modal-header"></div>
    <div class="modal-body">
        <form method="POST">
            <select name="urgency" id="urgency" class="urgency">
                <option value="" selected>Select</option>
                <option value="urgent">
                    Urgent
                </option>
                <option value="trivial">
                    Trivial
                </option>
            </select>
            <input type="submit" class="send-req-btn" value="Send request">
        </form>
    </div>
</div>
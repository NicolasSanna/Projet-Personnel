function passwordManager ()
{
    this.construct = function()
    {
        let passwordBtn = document.getElementById('viewPassword');     
        passwordBtn.addEventListener('click', this.passwordVisibility);
    }

    this.passwordVisibility = function ()
    {
        let passwordLabel = document.getElementById('password');

        if (passwordLabel.type === "password")
        {
            passwordLabel.type = "text";
        }
        else if (passwordLabel.type === "text")
        {
            passwordLabel.type = "password";
        }
        return
    }

    this.construct();
}
password = new passwordManager ()
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
            passwordBtn.style.backgroundColor = '#CD853F';
        }
        else if (passwordLabel.type === "text")
        {
            passwordLabel.type = "password";
        }
        return
    }

    this.construct();
}
const passwordVisible = new passwordManager ()
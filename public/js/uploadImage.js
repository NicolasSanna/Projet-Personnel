class UploadImageManager
{
    constructor()
    {
        const inputFile = document.getElementById('upload');
        inputFile.addEventListener('change', this.onChangeFile)
    }

    onChangeFile (event)
    {
        if(event.target.files.length > 0)
        {
            let src = URL.createObjectURL(event.target.files[0]);
            let preview = document.querySelector('.Article-box-img');
            preview.src = src;
        }
    }
}

const UploadFile = new UploadImageManager();
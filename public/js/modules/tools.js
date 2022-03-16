export class Tools
{
    static htmlspecialcharsJS(string)
    {
        return string.replace(/[&<>'"]/g, function (x)
        {
            return '&#' + x.charCodeAt(0) + ';';
        })
    }
}
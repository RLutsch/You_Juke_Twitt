function getStr(str, index)
{
	var res = "";
	index++;
	while (str[index] != ' ' && index < str.length)
	{
		res = res.concat(str[index]);
		index++;
	}
	return (res);
}

function proc(string)
{
  var str = "";
  var i = 0;
  var keyword = "";
  while (i < string.length)
    {
      if (string[i] == '@' || string[i] == '#')
      {
        	keyword = getStr(string, i);
        	str = str.concat('<a class="hash_tag" href="https://twitter.com/');
        	if (string[i] == '@')
        		str = str.concat(keyword + '">@' + keyword + '</a>');
        	else
        	{
          		str = str.concat('hashtag/' + keyword + '?src=hash');
          		str = str.concat('">#' + keyword + '</a>');
          	}
          i += keyword.length;
      }
      else if (string.substr(i, 4) == "http" || string.substr(i, 5) == "https")
      {
      	i -= 1;
      	keyword = getStr(string, i);
      	i++;
      	str = str.concat('<a class="hash_tag" href="' + keyword + '">' + keyword + '</a>');
      	i += keyword.length;
      }
      else
        str = str.concat(string[i]);
      i++;
    }
  return (str);
}
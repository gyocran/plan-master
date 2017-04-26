<html>
	<head>
		<title>{$title}</title>
	</head>
	<body>
		<p>{$message}</p>
		Looping through some names:
		
		{section name=outer
    	loop=$FirstName}
        {if $smarty.section.outer.index is odd by 2}
            {$smarty.section.outer.rownum} . {$FirstName[outer]}
        {else}
            {$smarty.section.outer.rownum} * {$FirstName[outer]}
        {/if}
        {sectionelse}
        none
    {/section}
	</body>
</html>
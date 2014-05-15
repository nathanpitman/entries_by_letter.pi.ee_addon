entries_by_letter.pi.ee_addon
=============================

Returns entries by letter, i.e. you can ask it  to return entries which start with one or more letters.

You can use this plug-in to return entry IDs of entries matching on start letter(s):

```{exp:entries_by_letter field_id="field_id_4" channel_id="2" letters="ABCDE"}```

You can choose to pass multiple or single letters. An example:

```
{exp:channel:entries entry_id="{exp:entries_by_letter field_id='title' channel_id='1' letters='ABC'}" dynamic="no" parse="inward"}
{title}
{/exp:channel:entries}
```

NOTE: Make sure you include 'parse="inward"' in your channel entries tag to force the correct parsing order else this plug-in will not work.

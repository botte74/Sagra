option explicit
 
 Dim TargetFolder, objShell, objFolder, colItems, filesys, objItem 
 Dim sTmp, AllFiles, UAF, x
 dim fso, afile
 
 'Script by TomRiddle 2008
 'Print all files in folder in Alphabetical order
 'Version 2
WScript.Echo "Hello"

Do
 'Folder of files you wish to print
    TargetFolder = "C:\Program Files (x86)\EasyPHP-DevServer-14.1VC11\data\localweb\sagra7\stampa_scontrini\" 
 
    Set objShell = CreateObject("Shell.Application") 
    Set objFolder = objShell.Namespace(TargetFolder) 
    Set colItems = objFolder.Items 
    set filesys = CreateObject("Scripting.FileSystemObject")
    'Set obj = CreateObject("Scripting.FileSystemObject") 'Calls the File System Object
	stmp = ""
 
 'Loop through all items in target folder, ignoring directories, add files to string separated by inverted commas
    For Each objItem in colItems 
      If not filesys.FolderExists(TargetFolder&objItem.name) Then
         sTmp=sTmp&objItem.name&vbtab 
      End If
    Next 
 
 'Sort string of files alphabetically
    sTmp = BubbleSort(sTmp)
 
 'Split string into array and loop through all items
 'msgbox stmp
    AllFiles=split(sTmp, vbtab)
    UAF=ubound(AllFiles)-1
	'msgbox uaf
	if uaf < 0 then
	WScript.Echo "niente da stampare"
	end if
    if uaf >= 0 then
    for x=0 to UAF
	  WScript.Echo "stampo " &TargetFolder&AllFiles(x)
      PrintFile AllFiles(x), TargetFolder
 'I put a sleep here because docs were printing out of order. 
       wscript.sleep(6000) '6 seconds but you may need to fine tune this.
	   'msgbox TargetFolder&AllFiles(x)
	   Set fso = CreateObject("Scripting.FileSystemObject") 'Calls the File System Object
	   set afile = fso.getfile(TargetFolder&AllFiles(x))
		afile.delete
    next
	end if
	
	wscript.sleep(2000)
Loop While (1=1)
 
    wscript.quit
 
 '-------------------------------------------------------------------------
 
 Sub PrintFile(TargetFile, TargetFolder)
 'Print the file
 
    Dim oShell, oFolder, cItems, oItem 
 
 'Following message box only included for testing. 
    'msgbox "Printing "&TargetFolder&TargetFile
 
    on error resume next
 
    Set oShell = CreateObject("Shell.Application")
    Set oFolder = oShell.Namespace(TargetFolder) 
    Set cItems = oFolder.Items 
    If cItems.Count > 0 Then    
       For each oItem in cItems        
          If oItem.Name = TargetFile Then             
             oItem.InvokeVerb("Print")            
             Exit For        
          End If    
       Next
       if err <> 0 then msgbox "Error trying to print "&TargetFolder&TargetFile
    End If 
 
    on error goto 0
  
 End Sub
 
 '-------------------------------------------------------------------------
 
 Function BubbleSort(sTmp)
 'Turn string into an array, sort it and turn it back into a string.
    Dim aTmp, i, j, temp
 
    aTmp = Split(sTmp, vbtab)  
    For i = UBound(aTmp) - 1 To 0 Step -1
       For j = 0 to i - 1
          If LCase(aTmp(j)) > LCase(aTmp(j+1)) Then
             temp = aTmp(j + 1)
             aTmp(j + 1) = aTmp(j)
             aTmp(j) = temp
          End if
       Next
     Next
     BubbleSort = Join(aTmp, vbtab)
 
 End Function
 
 '-------------------------------------------------------------------------
 
 

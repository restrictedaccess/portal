//2011-09-09 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  added mikes alertchat
//2010-11-15 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Retained the toggle function for the link on the "Click HERE to find out more about RSSC"
//2010-03-04 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  Add a note regarding RSSC app
//2010-02-24 Normaneil Macutay <normanm@remotestaff.com.au>
// Added link "Monthly Cut Off Period and FAQs about pay"
// remove function showHSBC()
// remove acknowledgeAdmin()

//2010-02-23 Normaneil Macutay <normanm@remotestaff.com.au>
// Added link "Monthly Cut Off Period and FAQs about pay"
// add function showHSBC()
//2009-03-31 Lawrence Sunglao <locsunglao@yahoo.com>
//  -   Add a "Please select your client" if multiple clients
//2008-08-04 Lawrence Sunglao <locsunglao@yahoo.com>
//  add note feature 
//2008-08-13 Lawrence Sunglao <locsunglao@yahoo.com>
//  add previous month selection on the time sheet
//  show monthly time record
//  make the time records html snippet rather than json for faster display
//2008-07-02 10:30 Lawrence Sunglao<locsunglao@yahoo.com>
//  remove PM in/ PM out buttons
//  replace AM in with Start Working
//  replace AM out with Stop Working
connect(window, "onload", OnLoadTimeRecording);

function OnLoadTimeRecording(e) {
    connect('what_is_this_software', 'onclick', OnClickWhatIsThisSoftware);
    alertchat(0);
}


function OnClickWhatIsThisSoftware(e) {
    toggle('what_is_this_software_desc');
}

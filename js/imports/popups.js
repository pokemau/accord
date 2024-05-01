export function openPopUpForm(callingButton){
    let callingButtonDiv = $(callingButton).parent()
    let callingPopUpForm = $(callingButtonDiv).parent();

    callingPopUpForm.addClass("blur");
    callingPopUpForm.removeClass("unblurred");

    let index = 0;

    //if multiple popUpForm are children of this popUpForm
    if($(callingPopUpForm).find('.divSubmitBtn').length > 1){
        index = $(callingPopUpForm).find('.divSubmitBtn').index(callingButtonDiv);
    }

    let childPopUpForm =  $(callingPopUpForm).find('.popUpForm')[index];
    $(childPopUpForm).show();
};
export function closePopUpForm(callingButton){
    let callingPopUpForm = $(callingButton).parent().parent();
    callingPopUpForm.addClass("unblurred");
    callingPopUpForm.hide();
    let parentPopUpForm =  $(callingPopUpForm).parent();
    if($(parentPopUpForm).is('body')) {
        refresh();
        return;
    }
    parentPopUpForm.removeClass("blur");
    parentPopUpForm.addClass("unblurred");
}
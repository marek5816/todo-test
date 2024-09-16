function resetFormFields(button) {
    const form = button.closest('form');

    form.querySelectorAll('input[type="text"]').forEach(input => {
        input.value = '';
    });

    form.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
        input.checked = false;
    });

    form.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    form.submit();
}
window.resetFormFields = resetFormFields;

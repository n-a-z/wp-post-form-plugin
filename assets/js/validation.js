if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

function isEmpty(str) {
  return !str.trim().length;
}

function validateForm() {
  let title = document.forms['post_form']['post_form_title'].value;
  let content = document.forms['post_form']['post_form_content'].value;
  if (isEmpty(title) && isEmpty(content)) {
    alert('Post Title and Content must be filled out');
    return false;
  } else {
    if (isEmpty(title)) {
      alert('Post Title must be filled out');
      return false;
    }
    if (isEmpty(content)) {
      alert('Post Content must be filled out');
      return false;
    }
  }
}

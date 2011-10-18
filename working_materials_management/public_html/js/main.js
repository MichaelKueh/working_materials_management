function deletePost(id) {
	apprise('Soll der Eintrag wirklich gel&ouml;scht werden?', {'verify':true, 'textYes': 'Ja', 'textNo' : 'Nein'}, function(r) {
	    if(r) {
	    	$("#post_" + id).fadeOut();
	    	jQuery.ajax("index.php?action=delete&type=post&post=" + id);
	    } else {
	       
	    }
	});
}

function deleteComment(id) {
	apprise('Soll der Kommentar wirklich gel&ouml;scht werden?', {'verify':true, 'textYes': 'Ja', 'textNo' : 'Nein'}, function(r) {
	    if(r) {
	    	$("#comment_" + id).fadeOut();
	    	jQuery.ajax("index.php?action=delete&type=comment&comment=" + id);
	    } else {
	       
	    }
	});
}
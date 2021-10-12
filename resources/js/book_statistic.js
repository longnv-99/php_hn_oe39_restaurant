window.onload = function () {
    var likeChart = $('#like-chart'),
        reviewChart = $('#review-chart'),
        commentChart = $('#comment-chart'),
        books = JSON.parse($('#books').val()),
        bookComments = JSON.parse($('#book-comments').val()),
        titles1 = [],
        titles2 = [],
        likes = [],
        reviews = [],
        comments = [],
        backgroundColor1 = [],
        backgroundColor2 = [];

    for (var i = 0; i < books.length; i++) {
        titles1.push(books[i]['title']);
        likes.push(books[i]['total_like']);
        reviews.push(books[i]['total_review']);

        randomColor = Math.floor(Math.random()*16777215).toString(16);
        backgroundColor1.push('#' + randomColor);
    }

    for (var i = 0; i < bookComments.length; i++) {
        titles2.push(bookComments[i]['title']);
        comments.push(bookComments[i]['total_cmt']);

        randomColor = Math.floor(Math.random()*16777215).toString(16);
        backgroundColor2.push('#' + randomColor);
    }

    var myChart1 = new Chart(likeChart, {
        type: 'doughnut',
        data: {
            labels: titles1,
            datasets: [
                {
                    label: 'Like',
                    data: likes,
                    backgroundColor: backgroundColor1
                },
            ]
        }
    });
    var myChart2 = new Chart(reviewChart, {
        type: 'pie',
        data: {
            labels: titles1,
            datasets: [
                {
                    label: 'Review',
                    data: reviews,
                    backgroundColor: backgroundColor1
                },
            ]
        }
    });
    var myChart3 = new Chart(commentChart, {
        type: 'doughnut',
        data: {
            labels: titles2,
            datasets: [
                {
                    label: 'Comment',
                    data: comments,
                    backgroundColor: backgroundColor2
                },
            ]
        }
    });
};

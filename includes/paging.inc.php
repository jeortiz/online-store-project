<?php

if($totalItems > $pageSize) {
    $totalPages = ceil($totalItems / $pageSize);

    echo "<div class='pagination'>";

    $previous = $currentPage == 0 ? 0 : $currentPage - 1;
    $next = $currentPage + 1;
    echo "<ul>";
    if($previous > 0) {
        echo "<li class='pagination-previous'><a href='index.php?catalogpage={$previous}'>Previous</a></li>";
    }

    for ( $i = 1 ; $i <= $totalPages; $i++) {
        if($i == $currentPage) {
            echo "<li>{$i}</li>";
        }
        else {
            echo "
                        <li>
                            <a href='index.php?catalogpage={$i}'>{$i}</a>
                        </li>";
        }
    }
    if($currentPage < $totalPages) {
        echo "<li class='pagination-next'><a href='index.php?catalogpage={$next}'>Next</a></li>";
    }

    echo "
            </ul>
        </div>";
}
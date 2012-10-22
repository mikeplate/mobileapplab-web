<!DOCTYPE html>
<?php
$has_viewport = true;
if (strpos($_SERVER['REQUEST_URI'], 'meta=no')>0)
    $has_viewport = false;
?>
<html>
    <head>
        <?php
        if ($has_viewport) {
        ?>
        <meta name="viewport" content="width=device-width" />
        <?php
        }
        ?>
        <style>
        body {
            margin: 0px;
        }
        div {
            width: 80px;
            height: 80px;
            margin: 5px;
            padding: 5px;
            float: left;
            text-align: center;
            font-size: 30px;
            font-family: sans-serif;
            font-weight: bold;
            background-color: black;
            color: white;
        }
        div:nth-child(even) {
            background-color: #ee6;
            color: black;
        }
        </style>
    </head>
    <body>
        <ul>
            <li>
            <?php
            if ($has_viewport) {
            ?>
                <h2>This page has a viewport</h2>
                <p><a href="/detection/viewport.demo?meta=no">Touch here to show without viewport meta tag</a></p>
            <?php
            }
            else {
            ?>
                <h2>No viewport in sight, using default</h2>
                <p><a href="/detection/viewport.demo">Touch here to show with viewport meta tag</a></p>
            <?php
            }
            ?>
            </li>
        </ul>
        <div>1</div>
        <div>2</div>
        <div>3</div>
        <div>4</div>
        <div>5</div>
        <div>6</div>
        <div>7</div>
        <div>8</div>
        <div>9</div>
        <div>10</div>
        <div>11</div>
        <div>12</div>
        <div>13</div>
        <div>14</div>
        <div>15</div>
        <div>16</div>
        <div>17</div>
        <div>18</div>
        <div>19</div>
        <div>20</div>
        <div>21</div>
        <div>22</div>
        <div>23</div>
        <div>24</div>
        <div>25</div>
        <div>26</div>
        <div>27</div>
        <div>28</div>
        <div>29</div>
        <div>30</div>
        <div>31</div>
        <div>32</div>
        <div>33</div>
        <div>34</div>
        <div>35</div>
        <div>36</div>
        <div>37</div>
        <div>38</div>
        <div>39</div>
    </body>
</html>


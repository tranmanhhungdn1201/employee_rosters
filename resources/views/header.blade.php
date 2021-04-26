<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.html">Employee Roster</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Roster<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.html">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">RollPay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">{{auth()->user()->username}}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
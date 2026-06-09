<?php 
include "include/config.php";
include "include/header.php"; ?>

<?php

// Total users
$userCountQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total_users FROM users"
);

$userCount = mysqli_fetch_assoc($userCountQuery)['total_users'];


// Total skills
$skillCountQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total_skills FROM skills"
);

$skillCount = mysqli_fetch_assoc($skillCountQuery)['total_skills'];


// Total skill requests
$requestCountQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total_requests FROM skill_requests"
);

$requestCount = mysqli_fetch_assoc($requestCountQuery)['total_requests'];

?>

<?php

$latestSkills = mysqli_query(
    $conn,
    "SELECT *
     FROM skills
     ORDER BY id DESC
     LIMIT 6"
);

$recentUsers = mysqli_query(
    $conn,
    "SELECT fullname
     FROM users
     ORDER BY id DESC
     LIMIT 4"
);

?>
<!-- HERO -->
<section class="hero">

    <div class="hero-content">

        <h1>Learn, Teach & Grow Together</h1>

        <p>
            Skill Exchange Platform enables individuals to share
            knowledge, learn new skills, and connect with others
            through collaborative learning experiences.
        </p>

        <div class="hero-buttons">
            <a href="pages/register.php" class="btn-primary">
                Get Started
            </a>

            <a href="pages/login.php" class="btn-secondary">
                Login
            </a>
        </div>

    </div>

</section>

<!-- MISSION -->
<section class="features">

    <h2>Our Mission</h2>

    <div class="feature-card">

        <p>
            Our mission is to make learning accessible through
            peer-to-peer knowledge sharing, allowing individuals
            to teach what they know and learn what they need.
        </p>

    </div>

</section>

<!-- FEATURES -->
<section class="features">

    <h2>Why Choose Skill Exchange?</h2>

    <div class="feature-grid">

        <div class="feature-card">
            <h3>📚 Learn New Skills</h3>
            <p>
                Access knowledge from people with different
                experiences and expertise.
            </p>
        </div>

        <div class="feature-card">
            <h3>🎓 Teach Others</h3>
            <p>
                Share your skills and contribute to the growth
                of the community.
            </p>
        </div>

        <div class="feature-card">
            <h3>🤝 Build Connections</h3>
            <p>
                Meet learners and professionals with similar
                interests and goals.
            </p>
        </div>

    </div>

</section>

<!-- HOW IT WORKS -->
<section class="features">

    <h2>How It Works</h2>

    <div class="feature-grid">

        <div class="feature-card">
            <h3>1️⃣ Register</h3>
            <p>Create your free account.</p>
        </div>

        <div class="feature-card">
            <h3>2️⃣ Add Skills</h3>
            <p>Share skills you can teach.</p>
        </div>

        <div class="feature-card">
            <h3>3️⃣ Connect</h3>
            <p>Find people and start learning.</p>
        </div>

    </div>

</section>

<!-- BENEFITS -->
<section class="features">

    <h2>Benefits</h2>

    <div class="feature-grid">

        <div class="feature-card">
            <h3>🚀 Career Development</h3>
            <p>
                Gain practical skills that can improve
                your employability.
            </p>
        </div>

        <div class="feature-card">
            <h3>💡 Knowledge Sharing</h3>
            <p>
                Encourage learning through collaboration.
            </p>
        </div>

        <div class="feature-card">
            <h3>🌍 Community Building</h3>
            <p>
                Create valuable professional and personal
                networks.
            </p>
        </div>

    </div>

</section>

<!-- STATISTICS -->
<section class="stats">

    <div class="stats-grid">

        <div class="stat-card">
            <h2><?php echo $userCount; ?>+</h2>
            <p>Registered Users</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $skillCount; ?>+</h2>
            <p>Skills Shared</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $requestCount; ?>+</h2>
            <p>Skill Requests</p>
        </div>

        <div class="stat-card">
            <h2>95%</h2>
            <p>User Satisfaction</p>
        </div>

    </div>

</section>

<section class="features">

    <h2>Latest Skills Shared</h2>

    <div class="feature-grid">

        <?php
        if(mysqli_num_rows($latestSkills) > 0)
        {
            while($skill = mysqli_fetch_assoc($latestSkills))
            {
        ?>

            <div class="feature-card">

                <h3>
                    <?php echo htmlspecialchars($skill['skill_name']); ?>
                </h3>

                <p>
                    <?php
                    echo htmlspecialchars(
                        substr($skill['description'], 0, 120)
                    );
                    ?>
                    ...
                </p>

            </div>

        <?php
            }
        }
        else
        {
            echo "
            <div class='feature-card'>
                <h3>No Skills Yet</h3>
                <p>
                    Skills added by users will appear here.
                </p>
            </div>";
        }
        ?>

    </div>

</section>

<!-- TESTIMONIALS -->
<section class="features">

    <h2>User Experiences</h2>

    <div class="feature-grid">

        <div class="feature-card">
            <p>
                "I learned graphic design skills from another
                student and improved my portfolio."
            </p>
            <h3>- Student User</h3>
        </div>

        <div class="feature-card">
            <p>
                "Teaching programming helped me improve my
                communication skills."
            </p>
            <h3>- Developer</h3>
        </div>

        <div class="feature-card">
            <p>
                "The platform helped me connect with people
                who share my interests."
            </p>
            <h3>- Community Member</h3>
        </div>

    </div>

</section>

<!-- CALL TO ACTION -->
<section class="hero">

    <div class="hero-content">

        <h2>Start Your Learning Journey Today</h2>

        <p>
            Join Skill Exchange Platform and become part of
            a growing learning community.
        </p>

        <div class="hero-buttons">
            <a href="pages/register.php" class="btn-primary">
                Join Now
            </a>
        </div>

    </div>

</section>

<?php include "include/footer.php"; ?>
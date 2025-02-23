<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 🌟 Meta Information for SEO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Where’s The Candy? - Find Trick-or-Treat Hotspots & Spooky Fun!">
    <meta name="description" content="Discover the best Trick-or-Treat hotspots, haunted houses, and spooky Halloween decorations near you. Join our community and share your experiences!">
    <meta name="keywords" content="Halloween, Trick-or-Treat, Haunted Houses, Spooky Decorations, Halloween Events, Community">
    <meta name="author" content="Where’s The Candy?">
    
    <!-- 📢 Social Media Optimization (Open Graph) -->
    <meta property="og:title" content="Where’s The Candy? - Find Trick-or-Treat Hotspots & Spooky Fun!">
    <meta property="og:description" content="Join our community to find the best Halloween Trick-or-Treat spots, haunted houses, and spooky decorations. Get involved today!">
    <meta property="og:image" content="assets/images/social-preview.jpg">
    <meta property="og:url" content="https://wheresthecandy.org">
    <meta property="og:type" content="website">
    
    <!-- 🕸️ Favicon & Canonical -->
    <link rel="icon" type="image/png" href="../images/favicon.png">
    <link rel="canonical" href="http://wheresthecandy.org">
    
    <!-- 🎃 Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    
    <!-- 📊 Structured Data (Schema.org) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Where’s The Candy?",
        "url": "https://yourwebsite.com",
        "description": "Find the best Trick-or-Treat hotspots, haunted houses, and spooky decorations in your area."
    }
    </script>

    <title>Where’s The Candy? - Trick-or-Treat Hotspots & Spooky Fun</title>
</head>
<body>
<?php include "includes/header.php"; ?>

    <div class="container">
        <!-- 🔥 Banner Section -->
        <section class="banner content-block">
            <h1>Welcome to Where’s The Candy? 🎃</h1>
            <p>Find the best Trick-or-Treat hotspots, haunted houses, and spooky decorations in your area!</p>
            <p>
                🎃 <a href="map.php">View the Trick-or-Treat Map</a> |
                👻 <a href="community.php">Join the Spooky Community</a> |
                🕵️‍♂️ <a href="profile.php">View Your Profile</a>
            </p>
        </section>

        <!-- 🔥 Main Content Layout -->
        <div class="main-layout">
            <!-- Left Section -->
            <section class="latest-updates content-block">
                <h2>Latest Community Posts 📰</h2>
                <ul>
                    <li>New haunted house added!</li>
                    <li>Community event this weekend!</li>
                </ul>
            </section>

            <!-- Right Section -->
            <div class="right-content">
                <section class="community-highlights content-block">
                    <h2>Community Highlights ✨</h2>
                    <p>See what others are sharing about their spooky experiences!</p>

                    <ul class="middle-links">
                        <li><a href="decorations.php">Top 5 Decorations</a></li>
                        <li><a href="costumes.php">Top 5 Costumes</a></li>
                        <li><a href="scary-stories.php">Top 5 Scary Stories</a></li>
                    </ul>

                    <a href="events.php" class="bottom-link">Check Events</a>
                    <a href="community.php" class="bottom-link">Join the Community Now!</a>
                </section>

                <section class="spooky-stories content-block">
                    <h2>Spooky Stories 👻</h2>
                    <p>Read terrifying tales shared by our community!</p>

                    <ul class="middle-links">
                        <li><a href="stories/dracula.php">Dracula</a></li>
                        <li><a href="stories/frankenstein.php">Frankenstein</a></li>
                        <li><a href="stories/ghosts.php">Ghost Stories</a></li>
                    </ul>

                    <a href="stories.php" class="bottom-link">Read More</a>
                </section>

                <section class="featured-events content-block">
                    <h2>Halloween Events 🎭</h2>
                    <p>Discover upcoming haunted house tours and spooky attractions!</p>

                    <ul class="middle-links">
                        <li><a href="events/parade.php">Village Halloween Parade</a></li>
                        <li><a href="events/krewe.php">Krewe of BOO parade</a></li>
                        <li><a href="events/jackolantern.php">Jack-o’-lantern Nights</a></li>
                    </ul>

                    <a href="events.php" class="bottom-link">Check Events</a>
                </section>
            </div>
        </div>

        <!-- 🔥 Bottom Section -->
        <section class="top-decorations content-block">
            <h2>Top 5 Halloween Decorations 🎃</h2>
            <p>Discover the most spine-chilling, eye-catching Halloween displays shared by our community!</p>

            <div class="decorations-gallery">
                <img src="assets/images/decor1.avif" alt="Halloween Decoration 1">
                <img src="assets/images/decor2.jpg" alt="Halloween Decoration 2">
                <img src="assets/images/decor3.webp" alt="Halloween Decoration 3">
                <img src="assets/images/decor4.webp" alt="Halloween Decoration 4">
                <img src="assets/images/decor5.webp" alt="Halloween Decoration 5">
            </div>
        </section>
    </div>
</body>
</html>

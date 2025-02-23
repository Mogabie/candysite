document.addEventListener("DOMContentLoaded", async function () {
    let map = L.map('map').setView([41.8781, -87.6298], 12); // Default to Chicago

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    console.log("✅ Map initialized!");

    // 📍 Center Map to User's Location or ZIP
    await centerMapToUserLocation(map);

    // 🔍 Search Feature
    const searchInput = document.getElementById("map-search");
    if (searchInput) {
        searchInput.addEventListener("change", function () {
            let searchQuery = searchInput.value.trim();
            if (!searchQuery) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        alert("⚠️ Location not found.");
                        return;
                    }
                    const { lat, lon } = data[0];
                    map.setView([lat, lon], 13);
                    console.log(`🔍 Searched Location: [${lat}, ${lon}]`);
                })
                .catch(error => console.error("❌ Search error:", error));
        });
    } else {
        console.warn("⚠️ Search bar not found in the DOM.");
    }

    // 📌 Load Existing Locations from Database
    fetch("get_locations.php")
    .then(response => response.json())
    .then(data => {
        console.log("📌 Fetched Locations:", data); // Debugging log

        data.forEach(location => {
            console.log(`📍 Adding Marker: ${location.name} at ${location.lat}, ${location.lng}`); // Debugging log
            
            const emoji = location.type === "hotspot" ? "🍬" : location.type === "haunted" ? "👻" : "🎃";

            L.marker([parseFloat(location.lat), parseFloat(location.lng)])
                .addTo(map)
                .bindPopup(`<strong>${emoji} ${location.name}</strong><br>${location.address}`);
        });
    })
    .catch(error => console.error("❌ Error loading map locations:", error));


    // 📍 Handle Location Submission
    const locationForm = document.getElementById("location-form");

    if (locationForm) {
        locationForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            const name = document.getElementById("location-name").value;
            const address = document.getElementById("location-address").value;
            const type = document.getElementById("location-type").value;

            if (!name || !address || !type) {
                alert("⚠️ Please fill in all fields.");
                return;
            }

            console.log(`Submitting: ${name}, ${address}, ${type}`);

            try {
                const response = await fetch("add_location.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ name, address, type })
                });

                const result = await response.json();
                console.log("Response from server:", result);

                if (result.success) {
                    alert("✅ Location added successfully!");
                    location.reload(); // Refresh to see the new location
                } else {
                    alert("❌ Error: " + result.error);
                }
            } catch (error) {
                console.error("❌ Error submitting location:", error);
            }
        });
    } else {
        console.warn("⚠️ Location form not found in the DOM.");
    }
});

// ✅ Function to Center Map to User Location or ZIP
async function centerMapToUserLocation(map) {
    if (typeof userZip !== "undefined" && userZip.trim() !== "") {
        console.log("📌 User ZIP:", userZip);
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(userZip)}`);
            const data = await response.json();

            if (data.length > 0) {
                const { lat, lon } = data[0];
                map.setView([lat, lon], 13);
                console.log(`✅ Map centered to ZIP: ${userZip} at [${lat}, ${lon}]`);
                return;
            } else {
                console.warn("⚠️ Could not find coordinates for ZIP:", userZip);
            }
        } catch (error) {
            console.error("❌ Error fetching location for ZIP:", error);
        }
    }

    // 🌍 If no ZIP, use geolocation
    if ("geolocation" in navigator) {
        try {
            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                map.setView([lat, lon], 13);
                console.log(`📍 User location: [${lat}, ${lon}]`);

                // Reverse geocode to get ZIP code (optional)
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
                const data = await response.json();

                if (data.address && data.address.postcode) {
                    console.log(`📌 Detected ZIP Code: ${data.address.postcode}`);
                } else {
                    console.warn("⚠️ Could not detect ZIP code.");
                }
            }, (error) => {
                console.warn("⚠️ Geolocation permission denied, defaulting to Chicago.");
                map.setView([41.8781, -87.6298], 12); // Default to Chicago
            });
        } catch (error) {
            console.error("❌ Error getting user location:", error);
        }
    } else {
        console.warn("⚠️ Geolocation not available, defaulting to Chicago.");
        map.setView([41.8781, -87.6298], 12); // Default to Chicago
    }
}

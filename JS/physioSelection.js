// Sample data for physiotherapists
const physiotherapists = [
    { name: 'Dr. Alice Doe', location: 'New York', price: 'A', gender: 'female', image: '/public/profile1.jpg' },
    { name: 'Dr. Bob Smith', location: 'New York', price: 'A', gender: 'male', image: '/public/profile2.jpg' },
    { name: 'Dr. Carol Lee', location: 'Chicago', price: 'B', gender: 'female', image: '/public/profile3.jpg' },
    { name: 'Dr. David Kim', location: 'Los Angeles', price: 'B', gender: 'male', image: '/public/profile4.jpg' },
    { name: 'Dr. Emily Tan', location: 'Los Angeles', price: 'C', gender: 'female', image: '/public/profile5.jpg' },
    { name: 'Dr. Frank White', location: 'Chicago', price: 'C', gender: 'male', image: '/public/profile6.jpg' }
];

// Function to load physiotherapists into the categories
function loadPhysiotherapists(filter = {}) {
    ['A', 'B', 'C'].forEach(category => {
        const container = document.querySelector(`#category${category} .row`);
        container.innerHTML = ''; // Clear existing cards

        physiotherapists
            .filter(pt => (filter.location ? pt.location === filter.location : true))
            .filter(pt => (filter.price ? pt.price === filter.price : true))
            .filter(pt => (filter.gender ? pt.gender === filter.gender : true))
            .filter(pt => pt.price === category)
            .forEach(pt => {
                container.innerHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card physiotherapist-card">
                            <img src="${pt.image}" class="profile-image" alt="${pt.name}">
                            <div class="card-body">
                                <h5>${pt.name}</h5>
                                <p><strong>Location:</strong> ${pt.location}</p>
                                <p><strong>Gender:</strong> ${pt.gender}</p>
                                <a href="profile.html" class="btn book-now-btn w-100">Book Now</a>
                            </div>
                        </div>
                    </div>
                `;
            });
    });
}

// Event listener for filter button
document.getElementById('filterButton').addEventListener('click', () => {
    const location = document.getElementById('locationFilter').value === 'all' ? null : document.getElementById('locationFilter').value;
    const price = document.getElementById('priceFilter').value === 'all' ? null : document.getElementById('priceFilter').value;
    const gender = document.getElementById('genderFilter').value === 'all' ? null : document.getElementById('genderFilter').value;

    loadPhysiotherapists({ location, price, gender });
});

// Initial load
loadPhysiotherapists();

<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard - Agri Equipment Rentals</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../asset/css/company/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
        Agri Rentals
    </div>
    <div class="nav-links">
        <a href="index.php?url=company_dashboard">Dashboard</a>
        <a href="#my-instruments">My Instruments</a>
        <a href="#orders">Orders</a>
        <a href="index.php?url=logout" class="btn-logout">Logout</a>
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
            <span class="toggle-icon" id="themeIcon">🌙</span>
            <span class="toggle-text" id="themeText">Dark</span>
        </button>

    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Manage your agricultural equipment and rental orders</p>
    <span class="hero-badge">Equipment Rental Company</span>
</section>

<!-- Main Container -->
<div class="main-container">
    
    <!-- Top Section: Form + Instruments List -->
    <div class="top-section">
        
        <!-- Post New Machinery Form -->
        <div class="form-section">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Post New Machinery
            </h3>
            <p class="form-subtitle">Add equipment to your rental inventory</p>
            
            <form action="index.php?url=add_instrument" method="POST">
                <div class="form-group">
                    <label>Instrument Name</label>
                    <input type="text" name="name" placeholder="e.g. Tractor, Harvester" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Harvesting, Plowing">
                </div>
                <div class="form-group">
                    <label>Rental Price Per Day (৳)</label>
                    <input type="number" name="rental_price" placeholder="Enter daily rental price" required>
                </div>
                <div class="form-group">
                    <label>Selling Price (৳) - Optional</label>
                    <input type="number" name="selling_price" placeholder="Enter selling price if for sale">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the machine, its condition, features..."></textarea>
                </div>
                <button type="submit" class="btn-post">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Post Instrument
                </button>
            </form>
        </div>

        <!-- My Posted Instruments -->
        <div class="list-section" id="my-instruments">
            <h3>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                My Posted Instruments
            </h3>
            <table>
                <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Price (Rent/Day)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($myInstruments)): ?>
                        <?php foreach($myInstruments as $item): ?>
                            <tr>
                                <td>
                                    <span class="instrument-name"><?php echo htmlspecialchars($item['name']); ?></span><br>
                                    <span class="instrument-category"><?php echo htmlspecialchars($item['category']); ?></span>
                                </td>
                                <td><span class="price-tag">৳<?php echo $item['rental_price']; ?></span></td>
                                <td>
                                    <span class="badge <?php echo $item['availability'] == 'available' ? 'badge-available' : 'badge-rented'; ?>">
                                        <?php echo ucfirst($item['availability']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-edit" onclick='openEditModal(<?php echo json_encode($item); ?>)'>Edit</button>
                                    <a href="index.php?url=delete_instrument&id=<?php echo $item['id']; ?>" 
                                       class="btn-delete" 
                                       onclick="return confirm('Are you sure you want to delete this instrument?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="empty-row">No instruments found. Add one now!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-section" id="orders">
        
        <!-- Pending Purchase Orders -->
        <div class="section-header purchase">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <h2>Pending Purchase Orders</h2>
        </div>
        <table class="orders-table purchase">
            <thead>
                <tr>
                    <th>Instrument Name</th>
                    <th>Landowner Name</th>
                    <th>District</th>
                    <th>Phone Number</th>
                    <th>Price</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($purchaseOrders)): ?>
                    <?php foreach($purchaseOrders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['instrument_name']) ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= htmlspecialchars($order['district']) ?></td>
                        <td><?= htmlspecialchars($order['phone']) ?></td>
                        <td><span class="price-tag">৳<?= number_format($order['purchase_price'], 2) ?></span></td>
                        <td style="text-align: center;">
                            <a href="index.php?url=complete_order&id=<?= $order['id'] ?>&type=buy" 
                               class="btn-done"
                               onclick="return confirm('Mark this order as Done?')">Done</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="empty-row">No pending purchase orders.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br><br>

        <!-- Pending Rental Requests -->
        <div class="section-header rental">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                <line x1="6" y1="1" x2="6" y2="4"/>
                <line x1="10" y1="1" x2="10" y2="4"/>
                <line x1="14" y1="1" x2="14" y2="4"/>
            </svg>
            <h2>Pending Rental Requests</h2>
        </div>
        <table class="orders-table rental">
            <thead>
                <tr>
                    <th>Instrument Name</th>
                    <th>Landowner Name</th>
                    <th>District</th>
                    <th>Phone Number</th>
                    <th>Price</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($rentalOrders)): ?>
                    <?php foreach($rentalOrders as $rent): ?>
                    <tr>
                        <td><?= htmlspecialchars($rent['instrument_name']) ?></td>
                        <td><?= htmlspecialchars($rent['customer_name']) ?></td>
                        <td><?= htmlspecialchars($rent['district']) ?></td>
                        <td><?= htmlspecialchars($rent['phone']) ?></td>
                        <td><span class="price-tag">৳<?= number_format($rent['rental_price'], 2) ?>/day</span></td>
                        <td style="text-align: center;">
                            <a href="index.php?url=complete_order&id=<?= $rent['id'] ?>&type=rent" 
                               class="btn-done"
                               onclick="return confirm('Mark this rental as Done?')">Done</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="empty-row">No pending rental requests.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Edit Instrument</h3>
        <hr>
        <form action="index.php?url=edit_instrument" method="POST">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            
            <div class="form-group">
                <label>Category:</label>
                <input type="text" name="category" id="edit_cat">
            </div>
            
            <div class="form-group">
                <label>Rental Price (৳):</label>
                <input type="number" name="rental_price" id="edit_rprice" required>
            </div>
            
            <div class="form-group">
                <label>Selling Price (৳):</label>
                <input type="number" name="selling_price" id="edit_sprice">
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" id="edit_desc"></textarea>
            </div>
            
            <button type="submit" class="btn-update">Update Changes</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_name').value = item.name;
        document.getElementById('edit_cat').value = item.category;
        document.getElementById('edit_rprice').value = item.rental_price;
        document.getElementById('edit_sprice').value = item.selling_price;
        document.getElementById('edit_desc').value = item.description;
        
        document.getElementById('editModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('editModal').style.display = "none";
    }

    window.onclick = function(event) {
        let modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

// dark and light theme switch
<script>
  (function () {
    const root = document.documentElement;
    const btn = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");
    const text = document.getElementById("themeText");

    // Load saved theme (default dark)
    const saved = localStorage.getItem("theme") || "dark";
    setTheme(saved);

    btn.addEventListener("click", () => {
      const current = root.getAttribute("data-theme") === "light" ? "light" : "dark";
      const next = current === "light" ? "dark" : "light";
      setTheme(next);
      localStorage.setItem("theme", next);
    });

    function setTheme(mode) {
      if (mode === "light") {
        root.setAttribute("data-theme", "light");
        icon.textContent = "☀️";
        text.textContent = "Light";
      } else {
        root.removeAttribute("data-theme");
        icon.textContent = "🌙";
        text.textContent = "Dark";
      }
    }
  })();
</script>


</body>
</html>

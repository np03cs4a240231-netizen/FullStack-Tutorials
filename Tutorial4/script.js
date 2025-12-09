// Simple JavaScript for Pranjal's Portfolio

// Function to scroll to projects section
function scrollToProjects() {
    document.getElementById('projects').scrollIntoView({ 
        behavior: 'smooth' 
    });
}

// Function to show hire message
function showHireMessage() {
    alert("Thanks for your interest! I'll contact you soon at pranjal1000@gmail.com");
}

// Wait for page to load
window.onload = function() {
    
    // Get the projects section
    const projectsSection = document.getElementById('projects');
    
    // Add click event to show more projects
    projectsSection.onclick = function() {
        
        // New projects to add
        const newProjects = [
            "To-Do List App - A simple task manager",
            "Calculator - Basic math operations",
            "Blog Website - Personal blogging platform",
            "Recipe Finder - Search for cooking recipes",
            "Expense Tracker - Track your daily expenses"
        ];
        
        // Add each new project
        newProjects.forEach(projectText => {
            // Create new project card
            const newCard = document.createElement('div');
            newCard.className = 'project-card';
            
            // Split title and description
            const parts = projectText.split(' - ');
            
            // Add title
            const title = document.createElement('h3');
            title.textContent = parts[0];
            newCard.appendChild(title);
            
            // Add description
            const description = document.createElement('p');
            description.textContent = parts[1];
            newCard.appendChild(description);
            
            // Add to projects section
            projectsSection.appendChild(newCard);
        });
        
        // Remove the hint text
        const hint = document.querySelector('.click-hint');
        if (hint) {
            hint.textContent = "(5 more projects loaded!)";
            hint.style.color = "green";
        }
        
        // Disable further clicks
        projectsSection.style.cursor = 'default';
        projectsSection.onclick = null;
        
        // Show success message
        setTimeout(() => {
            alert("5 more projects added! Total: " + 
                  document.querySelectorAll('.project-card').length + " projects");
        }, 300);
    };
    
    // Add hover effect to all project cards
    const allCards = document.querySelectorAll('.project-card');
    allCards.forEach(card => {
        card.onmouseover = function() {
            this.style.transform = 'scale(1.02)';
        };
        
        card.onmouseout = function() {
            this.style.transform = 'scale(1)';
        };
    });
    
    // Add click effect to skills
    const skills = document.querySelectorAll('.skills li');
    skills.forEach(skill => {
        skill.onclick = function() {
            const skillName = this.textContent;
            alert("Skill: " + skillName + "\n\nI'm currently learning this skill!");
        };
    });
};
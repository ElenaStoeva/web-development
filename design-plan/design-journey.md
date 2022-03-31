# Project 2: Design Journey

**For each milestone, complete only the sections that are labeled with that milestone.** Refine all sections before the final submission. If you later need to update your plan, **do not delete the original plan, leave it place and append your new plan below the original.** Explain why you are changing your plan. Remember you are graded on your design process. Updating the plan documents your process!

**Replace ALL _TODOs_ with your work.** (There should be no TODOs in the final submission.)

Be clear and concise in your writing. Bullets points are encouraged.

**Everything, including images, must be visible in Markdown Preview.** If it's not visible in Markdown Preview, then we won't grade it. We won't give you partial credit either. **Your design journey should be easy to read for the grader; in Markdown Preview the question _and_ answer should have a blank line between them.**


## Design / Plan (Milestone 1)

**Make the case for your decisions using concepts from class, as well as other design principles, theories, examples, and cases from outside of class (includes the design prerequisite for this course).**

You can use bullet points and lists, or full paragraphs, or a combo, whichever is appropriate. The writing should be solid draft quality.

### Audiences (Milestone 1)

> Who are your site's audiences?
> Briefly explain who the intended audiences are for your project website.
> **DO NOT INVENT RANDOM AUDIENCES HERE!** Use the audiences from the requirements.

_Consumer_: parents with developing children. They care about creating nature-rich spaces and plan to garden using this site's data in order to provide high quality nature-rich places on a smaller scale around their homes and communities.

_Site Administrator_: members of the Playful Plants project. They develop a (searchable) database of playful plants that can support a range of nature play experiences, provide ideas and plant collections for themed nature play spaces & gardens, and develop a web resource for sharing these resources, including the ability to tailor selections and print plant lists.


### _Consumer_ Audience Goals (Milestone 1)

> Document your audience's goals.
> List each goal below. There is no specific number of goals required for this, but you need enough to do the job.
> **DO NOT INVENT RANDOM GOALS HERE OR STEREOTYPE HERE!** Your goals are things that your users want accomplish when using the site (e.g. print a list of plants). These are informed by the Playful Plants objectives. Review the assignment's requirements for details.

_Consumer_ Goal 1: View plants that are well-suited for play

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - Providing a catalog of plants on the website.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - A searchable catalog of plants will allow the consumers to view all plants in the database of the Playful Plants project.

_Consumer_ Goal 2: Sort and filter catalog of plants

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - Providing a sort/filter form.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - A sort/filter form will allow the consumers to sort and filter the catalog of plants based on their needs.

_Consumer_ Goal 3: Print a list of plants

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - Design the catalog in a format that is well-suited for printing.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - If the design of the site provides a catalog format that is well-suited for printing, the consumers will be able to easily print a list of the plants that they are interested in.

### _Consumer_ Persona (Milestone 1)

> Use the goals you identified above to develop a persona of your site's audience.
> Create your persona using GenderMag's customizable personas.
> Take a screenshot and include it here. Persona must be visible in Markdown Preview; do not use PDF format!

![Abi](abi.jpg)

### _Administrator_ Audience Goals (Milestone 1)

> Document your audience's goals.
> List each goal below. There is no specific number of goals required for this, but you need enough to do the job.
> **DO NOT INVENT RANDOM GOALS HERE OR STEREOTYPE HERE!** Your goals are things that your users want accomplish when using the site (e.g. print a list of plants). These are informed by the Playful Plants objectives. Review the assignment's requirements for details.

_Administrator_ Goal 1: Develop a searchable database of playful plants that can support a range of nature play experiences.

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - Through providing functionality for adding and deleting plants in the catalog.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - If the administrator has the ability to add and remove plants in the catalog, they can develop a useful database of playful plants that can be viewed and searched by the consumers.

_Administrator_ Goal 2: Provide ideas & plant collections for themed nature play spaces & gardens.

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - By providing a functuinality for tagging plants in the catalog.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - By tagging the plants in the catalog, the administrators will be able to tailor the plant selections and provide ideas for themes nature play spaces.

_Administrator_ Goal 3: Search through existing database and sort and filter catalog.

- **Design Ideas and Choices** _How will you meet those goals in your design?_
  - Through adding a searchable catalog as well as a sort/filter form.
- **Rationale & Additional Notes** _Justify your decisions; additional notes._
  - Through the catalog, the administrators will be able to view all plants in the existing database of the Playful Plants Project. The sort/filter form will also allow them to sort and filter the plants based on their needs.


### _Administrator_ Persona (Milestone 1)

> Use the goals you identified above to develop a persona of your site's audience.
> Create your persona using GenderMag's customizable personas.
> Take a screenshot and include it here. Persona must be visible in Markdown Preview; do not use PDF format!

![Tim](tim.jpg)


### Site Design (Milestone 1)

> Document your _entire_ design process. **We want to see iteration!**
> **Show us the evolution of your design from your first idea (sketch) to the final design you plan to implement (sketch).**
> **Show us how you decided what data to display to each audience.**
> **Plan your URLs for the site.**
> **Provide a brief explanation _underneath_ each design artifact (2-3 sentences).** Explain what the artifact is, how it meets the goals of your personas (**refer to your personas by name**).
>
> **Important!** Plan _all_ site requirements. Don't forget login and logout.

_Initial Designs / Design Iterations:_

The pictures below are the initial design that I planned during the lab session on Friday.


![Initial Design - Consumers](initial_design2.jpg)

![Initial Design - Login Page](initial_design1.jpg)

![Initial Design - Administrators](initial_design3.jpg)

In this design, there is a administrator view and a consumer view. The consumers only sees a sort and a filter form while the administrators also see an add form and their name in the right top corner.

_Final Design:_

The pictures below contain a revised version of the previous design.

![Consumers View](consumers.jpg)

This is the page that the consumers see. They can sort and filter the catalog using the buttons at the top. When they click on an image from the catalog, they are redirected to a details page for this specific plant.

![Login Page](login.jpg)

This is the login page that the administrators use to log in.

![Administrators View](administrators.jpg)

This is the administrators view of the site. They can sort and filter the data like the consumers. They can also add plants through a form, add tags, and remove plants.


### Design Pattern Explanation/Reflection (Milestone 1)

> Write a one paragraph (6-8 sentences) reflection explaining how you used design patterns for media catalogs in your site's final design.

One design pattern that I used is having a catalog of images in rows, each of each leading to a page specific for this image. I will also have a sort option with a drop-down menu, which is another common element in media catalogs. There will also be a filtering button, which opens a small window with filter options. This is something that I have seen in many media catalogs as well.


### Cognitive Styles Explanation/Reflection (Milestone 1)

> Write a one paragraph (6-8 sentences) reflection explaining how your final design supports the cognitive styles of each persona.

_Consumer Cognitive Styles Reflection:_

Abi would be able to view the whole catalog and get an idea about what the catalog looks like (comprehensive information processing style). Since Abi has lower self confidence about doing unfamiliar computing tasks, the design will be simple without many unnecesary features, which would make Abi feel more comfortable working with. This also correleates with Abi's attitude toward Risk: Abi's life is a little complicated and she rarely has spare time. Therefore, this simplified version will help her navigate through the website without spending too much time.


_Site Administrator Cognitive Styles Reflection:_

Tim's Motivations is to learn all the available functionality and likes tinkering and exploring the menu items and functions of the software. This design will allow him to do so by playing around with the sort and filter buttons. The Delete Plant button will also allow him to experiment with the add form by adding a plant and then removing it. The administrator's view of the website is a bit more complicated than the view for consumers but this is okay, since Tim has high confidence in his abilities with technology.


## Implementation Plan (Milestone 1, Milestone 2, Milestone 3, Final Submission)

### Database Schema (Milestone 1)

> Describe the structure of your database. You may use words or a picture. A bulleted list is probably the simplest way to do this. Make sure you include constraints for each field.
> **Hint: You probably need a table for "entries", `tags`, `"entry"_tags`** (stores relationship between entries and tags), and a `users` tables.
> **Hint: For foreign keys, use the singular name of the table + _id.** For example: `image_id` and `tag_id` for the `image_tags` (tags for each image) table.

Table: TODO

- field1: TYPE {constraints...},
- field2...
- TODO


### Database Query Plan (Milestone 1, Milestone 2, Milestone 3, Final Submission)

> Plan _all_ of your database queries. You may use natural language, pseudocode, or SQL.

```
TODO: Plan a query
```

```
TODO: Plan another query
```

TODO: ...


### Code Planning (Milestone 1, Milestone 2, Milestone 3, Final Submission)

> Plan any PHP code you'll need here using pseudocode.
> Tip: Break this up by pages. It makes it easier to plan.

```
TODO: WRITE YOUR PSEUDOCODE HERE, between the back-tick lines.
```

```
TODO: WRITE MORE PSEUDOCODE HERE, between the back-tick lines.
```

TODO: ...


### Accessibility Audit (Final Submission)

> Tell us what issues you discovered during your accessibility audit.
> What do you do to improve the accessibility of your site?

TODO


## Reflection (Final Submission)

### Audience (Final Submission)

> Tell us how your final site meets the goals of your audiences. Be specific here. Tell us how you tailored your design, content, etc. to make your website usable for your personas.

TODO


### Additional Design Justifications (Final Submission)

> If you feel like you haven’t fully explained your design choices in the final submission, or you want to explain some functions in your site (e.g., if you feel like you make a special design choice which might not meet the final requirement), you can use the additional design justifications to justify your design choices. Remember, this is place for you to justify your design choices which you haven’t covered in the design journey. You don’t need to fill out this section if you think all design choices have been well explained in the design journey.

TODO


### Self-Reflection (Final Submission)

> Reflect on what you learned during this assignment. How have you improved from Project 2? What would you do differently next time?

TODO


> Take some time here to reflect on how much you've learned since you started this class. It's often easy to ignore our own progress. Take a moment and think about your accomplishments in this class. Hopefully you'll recognize that you've accomplished a lot and that you should be very proud of those accomplishments!

TODO


### Grading: Step-by-Step Instructions (Final Submission)

> Write step-by-step instructions for the graders.
> The project if very hard to grade if we don't understand how your site works.
> For example, you must login before you can delete.
> For each set of instructions, assume the grader is starting from /

_View all entries:_

1. TODO

2.

_View all entries for a tag:_

1. TODO

2.

_View a single entry's details:_

1. TODO

2.

_How to insert and upload a new entry:_

1. TODO

2.

_How to delete an entry:_

1. TODO

2.

_How to edit and existing entry and its tags:_

1. TODO

2.

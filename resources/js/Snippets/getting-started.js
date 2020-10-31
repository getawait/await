// todo: figure out a way to improve this
const gettingStarted = ({ waitlistId, email }) => (language) => {
  switch (language) {
    case 'js':
      return `const data = {
  email: "${ email }",
  waitlist: "${ waitlistId }"
};

fetch("https://getawait.com/api/v1/subscribers", {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify(data)
})
  .then((response) => response.json())
  .catch((error) => console.log(error))
  .then((data) => console.log(data));`;
  }
}

export default gettingStarted;
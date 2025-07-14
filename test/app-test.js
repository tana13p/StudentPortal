import { Builder, By, Key, until } from 'selenium-webdriver';
import assert from 'assert';

async function runTests() {
    const driver = await new Builder().forBrowser('MicrosoftEdge').build();

    try {
        // Test 1: Display Student Details
        await driver.get('http://localhost/dbms/GUI.php');
        // Step 2: Select registration type as Already Registered
        await driver.findElement(By.name('registration_type')).sendKeys('Already Registered');
        // Step 3: Select role as Student
        await driver.findElement(By.name('role')).sendKeys('Student');
        // Step 4: Enter ID
        await driver.findElement(By.name('id')).sendKeys('111');
        // Step 5: Submit the form
        await driver.findElement(By.css('input[type="submit"]')).click();
        // Wait for the next page to load and check if table rows are present
        await driver.wait(until.elementLocated(By.tagName('tr')), 10000);
        const tableRows = await driver.findElements(By.tagName('tr'));
        assert.strictEqual(
            tableRows.length > 1,
            true,
            `Table should have rows. Found: ${tableRows.length}`
        );
console.log("test 1 successful");
        await driver.sleep(10000);

//         // Test 2: Add a New Student
        await driver.get('http://localhost/dbms/GUI.php');
        await driver.findElement(By.name('registration_type')).sendKeys('New Registration');
        await driver.findElement(By.name('role')).sendKeys('Student');
        await driver.findElement(By.name('id')).sendKeys('101');
        await driver.findElement(By.css('input[type="submit"]')).click();
        await driver.wait(until.elementLocated(By.name("Full_Name")), 10000);
        await driver.findElement(By.name('Full_Name')).sendKeys('DUMMY DUMMY DUMMY');
        await driver.findElement(By.name('Email_Address')).sendKeys('EXAMPLE@google.com');
        await driver.findElement(By.name('Date_of_Admission')).sendKeys('03-03-2020');
        await driver.findElement(By.name('Admission_Fees_Paid')).sendKeys('150000.00');
        await driver.findElement(By.name('First_Name')).sendKeys('DUMMY')
        await driver.findElement(By.name('Middle_Name')).sendKeys('DUMMY');
        await driver.findElement(By.name('Middle_Name')).sendKeys('DUMMY');
        await driver.findElement(By.name('SURNAME')).sendKeys('DUMMY');
        await driver.findElement(By.name('Father_Name')).sendKeys('DUMMY');
        await driver.findElement(By.name('Mother_Name')).sendKeys('DUMMY');
        await driver.findElement(By.name('Email_ID')).sendKeys('EXAMPLE@gmail.com');
        await driver.findElement(By.name('Contact_Number')).sendKeys('9999999999');
        await driver.findElement(By.name('Gender')).sendKeys('Female');
        await driver.findElement(By.name('Date_of_Birth')).sendKeys('12-01-2020');
        await driver.findElement(By.name('Gender')).sendKeys('Female');
        await driver.findElement(By.name('Category')).sendKeys('sc');
        await driver.findElement(By.name('Blood_Group')).sendKeys('A+');
        await driver.findElement(By.name('Physically_Handicap')).sendKeys('No');
        await driver.findElement(By.css('input[type="submit"]')).click();
        console.log("test 2 successful");
        await driver.sleep(10000);

        // Test 3: Update a Student
        await driver.get('http://localhost/dbms/GUI.php');
        await driver.findElement(By.name('registration_type')).sendKeys('Already Registered');
        await driver.findElement(By.name('role')).sendKeys('Student');
        await driver.findElement(By.name('id')).sendKeys('101');
        await driver.findElement(By.css('input[type="submit"]')).click();
        await driver.wait(until.elementLocated(By.css('input[name="update"]')), 10000);
        await driver.findElement(By.css('input[name="update"]')).click();
        await driver.wait(until.elementLocated(By.name("Full_Name")), 10000);
        await driver.findElement(By.name('Full_Name')).sendKeys('TEMPORARY');
        await driver.findElement(By.css('input[type="submit"]')).click();
        console.log("test 3 successful");
        await driver.sleep(10000);

        // Test 4: Delete a Student
        await driver.get('http://localhost/dbms/GUI.php');
        await driver.findElement(By.name('registration_type')).sendKeys('Already Registered');
        await driver.findElement(By.name('role')).sendKeys('Student');
        await driver.findElement(By.name('id')).sendKeys('101');
        await driver.findElement(By.css('input[type="submit"]')).click();
        await driver.wait(until.elementLocated(By.css('input[name="delete"]')), 10000);
        await driver.findElement(By.css('input[name="delete"]')).click();
        // Wait for the alert to be present
        await driver.wait(until.alertIsPresent(), 5000);
        // Switch to the alert
        let alert = await driver.switchTo().alert();
        // Accept the alert (Click "OK")
        await alert.accept();
        console.log("test 4 successful");
        await driver.sleep(10000);
    } catch (error) {
        console.error('Test failed:', error.message);
    } finally {
        // Close the browser after all tests are completed
        await driver.quit();
    }
}
// Run the tests
runTests();
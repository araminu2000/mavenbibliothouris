
describe("Courses", function() {

    var init    = false;
    var APP_URL = 'fakeUrl';

    beforeEach(function(){

        if (!init) {
			Courses.Init();
			init = true;
		}
	
    });

    describe("Try to see if Courses is object and is correctly instantiated", function(){

        it("Courses Variable should be object", function(){
            expect(typeof Courses).toEqual('object');
        });

        it("Courses.CONFIGS Should not be accessed from outside the object", function(){
            expect(Courses.CONFIGS).not.toBeDefined();
        });

        it("Courses.Init() is function and is accessible from outside, also it returns true since the object is initialized", function(){
            expect(typeof Courses.Init).toEqual('function');
            expect(Courses.Init()).toBe(true);
        });

    });


    describe("Verify if courses list is correctly loaded via AJAX", function(){

        it("LoadCoursesListFromDb function should be called", function() {

            spyOn($, "ajax").andCallFake(function(options){
                options.success();
            });

            var callBack = jasmine.createSpy();

            Courses.LoadCoursesListFromDb(APP_URL, callBack);

            expect(callBack).toHaveBeenCalled();

        });
    });


    describe("Verify if members list is correctly loaded via AJAX", function(){

        it("LoadMembersListFromDb function should be called", function() {

            spyOn($, "ajax").andCallFake(function(options){
                options.success();
            });

            var callBack = jasmine.createSpy();

            Courses.LoadMembersListFromDb(APP_URL, callBack);

            expect(callBack).toHaveBeenCalled();

        });
    });
    
    describe("Verify if courses followed by a member are loaded via AJAX", function(){

        it("LoadFollowedCoursesListFromDb function should be called", function() {

            spyOn($, "ajax").andCallFake(function(options){
                options.success();
            });

            var callBack = jasmine.createSpy();

            Courses.LoadFollowedCoursesListFromDb(APP_URL, callBack);

            expect(callBack).toHaveBeenCalled();

        });
    });


});


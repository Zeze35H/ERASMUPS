DROP INDEX IF EXISTS big_search_idx;
DROP INDEX IF EXISTS active_users_idx;
DROP INDEX IF EXISTS visible_content_idx;
DROP INDEX IF EXISTS pending_reports_idx;
DROP INDEX IF EXISTS pending_applications_idx;

DROP PROCEDURE IF EXISTS add_question;
DROP PROCEDURE IF EXISTS add_answer;
DROP PROCEDURE IF EXISTS add_comment;
DROP PROCEDURE IF EXISTS treat_report;

DROP TRIGGER IF EXISTS refresh_big_search_user ON "User";
DROP TRIGGER IF EXISTS refresh_big_search_tagged_question ON "TaggedQuestion";
DROP TRIGGER IF EXISTS refresh_big_question ON "Question";
DROP TRIGGER IF EXISTS rem_badge_notification ON "BadgeNotification";
DROP TRIGGER IF EXISTS rem_comment_notification ON "CommentNotification";
DROP TRIGGER IF EXISTS rem_answer_notification ON "AnswerNotification";
DROP TRIGGER IF EXISTS rem_tag_notification ON "TagNotification";
DROP TRIGGER IF EXISTS rem_favourite_answer_notification ON "FavouriteAnswerNotification";
DROP TRIGGER IF EXISTS rem_report_notification ON "ReportNotification";
DROP TRIGGER IF EXISTS add_vote_trigger ON "Vote";
DROP TRIGGER IF EXISTS rem_vote_trigger ON "Vote";
DROP TRIGGER IF EXISTS user_vote_trigger ON "Vote";
DROP TRIGGER IF EXISTS add_question_trigger ON "Question";
DROP TRIGGER IF EXISTS rem_question_trigger ON "Question";
DROP TRIGGER IF EXISTS add_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS rem_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS add_comment_trigger ON "Comment";
DROP TRIGGER IF EXISTS rem_comment_trigger ON "Comment";
DROP TRIGGER IF EXISTS add_fav_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS rem_fav_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS red_num_fav_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS mod_application_decision_trigger ON "ModApplication";
DROP TRIGGER IF EXISTS insert_question_with_followed_tag_trigger ON "TaggedQuestion";
DROP TRIGGER IF EXISTS earn_badge_trigger ON "User";
DROP TRIGGER IF EXISTS update_trust_level_trigger ON "User";
DROP TRIGGER IF EXISTS disjoint_question_trigger ON "Question";
DROP TRIGGER IF EXISTS disjoint_answer_trigger ON "Answer";
DROP TRIGGER IF EXISTS disjoint_comment_trigger ON "Comment";
DROP TRIGGER IF EXISTS disjoint_badge_not_trigger ON "BadgeNotification";
DROP TRIGGER IF EXISTS disjoint_comment_not_trigger ON "CommentNotification";
DROP TRIGGER IF EXISTS disjoint_answer_not_trigger ON "AnswerNotification";
DROP TRIGGER IF EXISTS disjoint_tag_not_trigger ON "TagNotification";
DROP TRIGGER IF EXISTS disjoint_fav_answer_not_trigger ON "FavouriteAnswerNotification";
DROP TRIGGER IF EXISTS disjoint_mod_not_trigger ON "ModNotification";
DROP TRIGGER IF EXISTS disjoint_report_not_trigger ON "ReportNotification";
DROP TRIGGER IF EXISTS report_notification_trigger ON "Report";
DROP TRIGGER IF EXISTS delete_user_trigger ON "User";
DROP TRIGGER IF EXISTS can_app_mod_trigger ON "ModApplication";
DROP TRIGGER IF EXISTS delete_content_trigger ON "Content";

DROP FUNCTION IF EXISTS refresh_big_search;
DROP FUNCTION IF EXISTS rem_badge_notification;
DROP FUNCTION IF EXISTS rem_comment_notification;
DROP FUNCTION IF EXISTS rem_answer_notification;
DROP FUNCTION IF EXISTS rem_tag_notification;
DROP FUNCTION IF EXISTS rem_favourite_answer_notification;
DROP FUNCTION IF EXISTS rem_report_notification;
DROP FUNCTION IF EXISTS add_vote_trigger;
DROP FUNCTION IF EXISTS rem_vote_trigger;
DROP FUNCTION IF EXISTS user_vote_trigger;
DROP FUNCTION IF EXISTS add_question_trigger;
DROP FUNCTION IF EXISTS rem_question_trigger;
DROP FUNCTION IF EXISTS add_answer_trigger;
DROP FUNCTION IF EXISTS rem_answer_trigger;
DROP FUNCTION IF EXISTS add_comment_trigger;
DROP FUNCTION IF EXISTS rem_comment_trigger;
DROP FUNCTION IF EXISTS add_fav_answer_trigger;
DROP FUNCTION IF EXISTS rem_fav_answer_trigger;
DROP FUNCTION IF EXISTS red_num_fav_answer_trigger;
DROP FUNCTION IF EXISTS mod_application_decision_trigger;
DROP FUNCTION IF EXISTS insert_question_with_followed_tag_trigger;
DROP FUNCTION IF EXISTS earn_badge_trigger;
DROP FUNCTION IF EXISTS update_trust_level_trigger;
DROP FUNCTION IF EXISTS disjoint_question_trigger;
DROP FUNCTION IF EXISTS disjoint_answer_trigger;
DROP FUNCTION IF EXISTS disjoint_comment_trigger;
DROP FUNCTION IF EXISTS disjoint_badge_not_trigger;
DROP FUNCTION IF EXISTS disjoint_comment_not_trigger;
DROP FUNCTION IF EXISTS disjoint_answer_not_trigger;
DROP FUNCTION IF EXISTS disjoint_tag_not_trigger;
DROP FUNCTION IF EXISTS disjoint_fav_answer_not_trigger;
DROP FUNCTION IF EXISTS disjoint_mod_not_trigger;
DROP FUNCTION IF EXISTS disjoint_report_not_trigger;
DROP FUNCTION IF EXISTS report_notification_trigger;
DROP FUNCTION IF EXISTS delete_user_trigger;
DROP FUNCTION IF EXISTS can_app_mod_trigger;
DROP FUNCTION IF EXISTS calc_num_interactions_on_content;
DROP FUNCTION IF EXISTS delete_content_trigger;
DROP FUNCTION IF EXISTS calc_last_app_date;

DROP MATERIALIZED VIEW IF EXISTS "big_search";

DROP TABLE IF EXISTS "EarnedBadge";
DROP TABLE IF EXISTS "Vote";
DROP TABLE IF EXISTS "ReportNotification";
DROP TABLE IF EXISTS "ModNotification";
DROP TABLE IF EXISTS "FavouriteAnswerNotification";
DROP TABLE IF EXISTS "TagNotification";
DROP TABLE IF EXISTS "AnswerNotification";
DROP TABLE IF EXISTS "CommentNotification";
DROP TABLE IF EXISTS "BadgeNotification";
DROP TABLE IF EXISTS "Notification";
DROP TABLE IF EXISTS "Report";
DROP TABLE IF EXISTS "ModApplication";
DROP TABLE IF EXISTS "Badge";
DROP TABLE IF EXISTS "QuestionImage";
DROP TABLE IF EXISTS "TaggedQuestion";
DROP TABLE IF EXISTS "FollowedTags";
DROP TABLE IF EXISTS "Tag";
DROP TABLE IF EXISTS "Comment";
DROP TABLE IF EXISTS "Answer";
DROP TABLE IF EXISTS "Question";
DROP TABLE IF EXISTS "Content";
DROP TABLE IF EXISTS "Admin";
DROP TABLE IF EXISTS "Mod";
DROP TABLE IF EXISTS "User";
DROP TABLE IF EXISTS "UserImage";

DROP TYPE IF EXISTS "badgetype";
DROP TYPE IF EXISTS "badgelevel";
DROP TYPE IF EXISTS "modapplicationstatus";
DROP TYPE IF EXISTS "reportstatus";

CREATE TYPE BadgeType AS ENUM ('Voting', 'Answering', 'Questioning', 'Commenting');
CREATE TYPE BadgeLevel AS ENUM ('Newbie', 'Junior', 'Expert', 'Master', 'Grandmaster');
CREATE TYPE ModApplicationStatus AS ENUM ('pending', 'accepted', 'rejected');
CREATE TYPE ReportStatus AS ENUM ('pending', 'ban_author', 'delete_content', 'ignore_report');

CREATE TABLE "UserImage" (
    "id" SERIAL PRIMARY KEY,
    "path" TEXT NOT NULL DEFAULT '../img/annon.png' CONSTRAINT "username_image_uk" UNIQUE
);

CREATE TABLE "User" (
    "id" SERIAL PRIMARY KEY,
    "username" TEXT NOT NULL CONSTRAINT "username_uk" UNIQUE, 
    "email" TEXT NOT NULL CONSTRAINT "email_uk" UNIQUE,
    "name" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "trust_level" INTEGER DEFAULT 0,
    "country" TEXT NOT NULL, 
    "bio" TEXT,
    "erasmus_in_out" BOOLEAN,
    "profile_picture_id" INTEGER REFERENCES "UserImage" ON DELETE SET NULL ON UPDATE CASCADE,
    "birthday" DATE NOT NULL,
    "num_votes" INTEGER NOT NULL,
    "num_questions" INTEGER NOT NULL CONSTRAINT "num_questions_ck" CHECK ("num_questions" >= 0),
    "num_comments" INTEGER NOT NULL CONSTRAINT "num_comments_ck" CHECK ("num_comments" >= 0),
    "num_reports" INTEGER NOT NULL CONSTRAINT "num_reports_ck" CHECK ("num_reports" >= 0),
    "num_answers" INTEGER NOT NULL CONSTRAINT "num_answers_ck" CHECK ("num_answers" >= 0),
    "num_fav_answers" INTEGER NOT NULL CONSTRAINT "num_fav_answers_ck" CHECK ("num_fav_answers" >= 0),
    "deleted" BOOLEAN DEFAULT false
);

CREATE TABLE "Mod" (
    "id" INTEGER NOT NULL PRIMARY KEY REFERENCES "User" ON DELETE CASCADE ON UPDATE CASCADE,
    "num_interactions" INTEGER NOT NULL CONSTRAINT "num_interactions_ck" CHECK ("num_interactions" >= 0)
);

CREATE TABLE "Admin" (
    "id" INTEGER NOT NULL PRIMARY KEY REFERENCES "Mod" ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "Content" (
    "id" SERIAL PRIMARY KEY,
    "text" TEXT NOT NULL,
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    "score" INTEGER NOT NULL DEFAULT 0,
    "user_id" INTEGER REFERENCES "User",
    "visible" BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE "Question" (
    "id" INTEGER NOT NULL PRIMARY KEY REFERENCES "Content" ON DELETE CASCADE ON UPDATE CASCADE,
    "title" TEXT NOT NULL
);

CREATE TABLE "Answer" (
    "id" INTEGER NOT NULL PRIMARY KEY REFERENCES "Content" ON DELETE CASCADE ON UPDATE CASCADE,
    "selected" BOOLEAN NOT NULL DEFAULT false,
    "question_id" INTEGER REFERENCES "Question" ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "Comment" (
    "id" INTEGER NOT NULL PRIMARY KEY REFERENCES "Content" ON DELETE CASCADE ON UPDATE CASCADE,
    "answer_id" INTEGER REFERENCES "Answer" ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "QuestionImage" (
    "id" SERIAL PRIMARY KEY,
    "path" TEXT NOT NULL CONSTRAINT "question_image_uk" UNIQUE,
    "question_id" INTEGER REFERENCES "Question" ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "Tag" (
    "id" SERIAL PRIMARY KEY,
    "text" TEXT NOT NULL CONSTRAINT "text_uk" UNIQUE,
    "equalTagsCnt" INTEGER NOT NULL DEFAULT 1 CONSTRAINT "equalTagsCnt_ck" CHECK ("equalTagsCnt" > 0)
);

CREATE TABLE "FollowedTags" (
    "tag_id" INTEGER REFERENCES "Tag"  ON DELETE CASCADE ON UPDATE CASCADE,
    "user_id" INTEGER REFERENCES "User"  ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY("tag_id", "user_id")
);

CREATE TABLE "TaggedQuestion" (
    "tag_id" INTEGER REFERENCES "Tag" ON DELETE CASCADE ON UPDATE CASCADE,
    "question_id" INTEGER REFERENCES "Question" ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY("tag_id", "question_id")
);

CREATE TABLE "Badge" (
    "id" SERIAL PRIMARY KEY,
    "type" BadgeType NOT NULL,
    "level" BadgeLevel NOT NULL,
    "min" INTEGER NOT NULL,
    CONSTRAINT "typeLevel" UNIQUE ("type","level"),
    CHECK ("min" > 0)
);

CREATE TABLE "ModApplication" (
    "id" SERIAL PRIMARY KEY,
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    "status" ModApplicationStatus DEFAULT 'pending',
    "user_id" INTEGER REFERENCES "User"  ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE "Report" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL REFERENCES "User", -- if user is eleiminated then it goes to anonymous
    "content_id" INTEGER NOT NULL REFERENCES "Content" ON UPDATE CASCADE ON DELETE CASCADE,
    "mod_id" INTEGER REFERENCES "Mod" ON UPDATE CASCADE ON DELETE SET NULL DEFAULT NULL ,
    "status" ReportStatus NOT NULL DEFAULT 'pending',
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    "reason" TEXT NOT NULL,
    CONSTRAINT "report_uk" UNIQUE("user_id", "content_id")
);

CREATE TABLE "Notification" (
    "id" SERIAL PRIMARY KEY,
    "text" TEXT NOT NULL,
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    "user_id" INTEGER REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "BadgeNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "badge_id" INTEGER NOT NULL REFERENCES "Badge" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "CommentNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "comment_id" INTEGER REFERENCES "Comment" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "AnswerNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "answer_id" INTEGER REFERENCES "Answer" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "TagNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "tag_id" INTEGER NOT NULL REFERENCES "Tag" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "FavouriteAnswerNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "answer_id" INTEGER REFERENCES "Answer" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "ModNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "ReportNotification" (
    "id" INTEGER PRIMARY KEY REFERENCES "Notification" ON UPDATE CASCADE ON DELETE CASCADE,
    "report_id" INTEGER NOT NULL REFERENCES "Report" ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "Vote" (
    "user_id" INTEGER REFERENCES "User",
    "content_id" INTEGER REFERENCES "Content" ON UPDATE CASCADE ON DELETE CASCADE,
    "value" BOOLEAN NOT NULL,
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    PRIMARY KEY ("user_id", "content_id")
);

CREATE TABLE "EarnedBadge" (
    "user_id" INTEGER REFERENCES "User" ON UPDATE CASCADE ON DELETE CASCADE,
    "badge_id" INTEGER REFERENCES "Badge" ON UPDATE CASCADE ON DELETE CASCADE,
    "timestamp" TIMESTAMP NOT NULL DEFAULT NOW(),
    PRIMARY KEY ("user_id", "badge_id")
);

/*      ---------------------- MATERIALIZED VIEW  ----------------------      */

CREATE MATERIALIZED VIEW "big_search" AS
	SELECT "Content"."id", "username", "title", "Content"."text", 
		COALESCE(
			(
				SELECT string_agg("Tag"."text", ' ')
				FROM "TaggedQuestion", "Tag"
				WHERE "TaggedQuestion"."question_id" = "Content"."id"
				AND "TaggedQuestion"."tag_id" = "Tag"."id"
				GROUP BY "username", "title", "Content"."text"
			)
			, '')  AS "tags",
		setweight(to_tsvector('simple', "title"), 'A')
		|| setweight(to_tsvector('simple', 
			COALESCE(
			(
				SELECT string_agg("Tag"."text", ' ')
				FROM "TaggedQuestion", "Tag"
				WHERE "TaggedQuestion"."question_id" = "Content"."id"
				AND "TaggedQuestion"."tag_id" = "Tag"."id"
				GROUP BY "username", "title", "Content"."text"
			)
			, '')
		), 'B') 
		|| setweight(to_tsvector('simple', "username"), 'C') 
		|| setweight(to_tsvector('simple', "Content"."text"), 'D') as "search"
	FROM "User", "Content", "Question"
	WHERE "User"."id" = "Content"."user_id" 
	AND "Content"."id" = "Question"."id";

/*      ---------------------- TRIGGERS  ----------------------      */

-- %%% FULL TEXT SEARCH UPDATE

CREATE FUNCTION refresh_big_search() RETURNS TRIGGER AS
$BODY$
BEGIN
    REFRESH MATERIALIZED VIEW "big_search";
    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER refresh_big_search_user 
AFTER INSERT OR UPDATE OR DELETE ON "User"
FOR EACH STATEMENT
EXECUTE PROCEDURE refresh_big_search();

CREATE TRIGGER refresh_big_search_tagged_question 
AFTER INSERT OR UPDATE OR DELETE ON "TaggedQuestion"
FOR EACH STATEMENT
EXECUTE PROCEDURE refresh_big_search();

CREATE TRIGGER refresh_big_question
AFTER INSERT OR UPDATE OR DELETE ON "Question"
FOR EACH STATEMENT
EXECUTE PROCEDURE refresh_big_search();

-- %%% NOTIFICATION

CREATE FUNCTION rem_badge_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_badge_notification
AFTER DELETE ON "BadgeNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_badge_notification();

CREATE FUNCTION rem_comment_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_comment_notification
AFTER DELETE ON "CommentNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_comment_notification();

CREATE FUNCTION rem_answer_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_answer_notification
AFTER DELETE ON "AnswerNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_answer_notification();

CREATE FUNCTION rem_tag_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_tag_notification
AFTER DELETE ON "TagNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_tag_notification();

CREATE FUNCTION rem_favourite_answer_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_favourite_answer_notification
AFTER DELETE ON "FavouriteAnswerNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_favourite_answer_notification();

CREATE FUNCTION rem_report_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM "Notification"
  WHERE "id" = OLD."id";
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_report_notification
AFTER DELETE ON "ReportNotification"
FOR EACH ROW
EXECUTE PROCEDURE rem_report_notification();

-- %%% VOTE

CREATE FUNCTION add_vote_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF NEW."value" THEN
		UPDATE "User"
		SET "num_votes" = "num_votes" + 1
		WHERE NEW."user_id" = "id" AND "deleted" = false;
		
		UPDATE "Content"
		SET "score" = "score" + 1
		WHERE NEW."content_id" = "id";
  ELSE
		UPDATE "User"
		SET "num_votes" = "num_votes" - 1
		WHERE NEW."user_id" = "id" AND "deleted" = false;
		
		UPDATE "Content"
		SET "score" = "score" - 1
		WHERE NEW."content_id" = "id";
  END IF;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER add_vote_trigger
AFTER INSERT ON "Vote"
FOR EACH ROW
EXECUTE PROCEDURE add_vote_trigger(); 

CREATE FUNCTION rem_vote_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
	IF OLD."value" THEN
		UPDATE "User"
		SET "num_votes" = "num_votes" - 1
		WHERE OLD."user_id" = "id" AND "deleted" = false;
		
		UPDATE "Content"
		SET "score" = "score" - 1
		WHERE OLD."content_id" = "id";
  ELSE
		UPDATE "User"
		SET "num_votes" = "num_votes" + 1
		WHERE OLD."user_id" = "id" AND "deleted" = false;
		
		UPDATE "Content"
		SET "score" = "score" + 1
		WHERE OLD."content_id" = "id";
  END IF;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER rem_vote_trigger
AFTER DELETE ON "Vote"
FOR EACH ROW
EXECUTE PROCEDURE rem_vote_trigger(); 

CREATE FUNCTION user_vote_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  
  IF EXISTS(SELECT * FROM "Content" WHERE "id" = NEW."content_id" AND "user_id" = NEW."user_id") THEN
    RAISE EXCEPTION 'An user can not vote in his own content.';
  END IF;

  DELETE FROM "Vote"
  WHERE NEW."user_id" = "user_id" AND NEW."content_id" = "content_id";

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER user_vote_trigger
BEFORE INSERT ON "Vote"
FOR EACH ROW
EXECUTE PROCEDURE user_vote_trigger(); 

--   %%% QUESTION

CREATE FUNCTION add_question_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
    --
    -- NumQuestions
    UPDATE "User"
    SET "num_questions" = "num_questions" + 1
    WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id") AND "deleted" = false;

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_question_trigger
AFTER INSERT ON "Question"
FOR EACH ROW
EXECUTE PROCEDURE add_question_trigger(); 

CREATE FUNCTION rem_question_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
    --
    -- NumQuestions
    UPDATE "User"
    SET "num_questions" = "num_questions" - 1
    WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = OLD."id") AND "deleted" = false;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_question_trigger
AFTER DELETE ON "Question"
FOR EACH ROW
EXECUTE PROCEDURE rem_question_trigger(); 

--   %%% ANSWER

CREATE FUNCTION add_answer_trigger() RETURNS TRIGGER AS
$BODY$
DECLARE 
  username1 text;
BEGIN
  --
  -- NumAnswers
  UPDATE "User"
  SET "num_answers" = "num_answers" + 1
  WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id") AND "deleted" = false;

  IF (SELECT "deleted" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."id") = false THEN 

    username1 := (SELECT "username" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."id");

    --
    -- Notification Table
    WITH "not" AS(
      INSERT INTO "Notification"("text", "user_id")
      VALUES (username1 || ' has answered to your question', (SELECT "user_id" FROM "Content" WHERE "id" = NEW."question_id"))
      RETURNING "id"
    )
    
    -- Answer Notification Table
    INSERT INTO "AnswerNotification"("id", "answer_id")
    VALUES ((SELECT "id" FROM "not"), NEW."id");
	END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_answer_trigger
AFTER INSERT ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE add_answer_trigger(); 

CREATE FUNCTION rem_answer_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
    --
    -- NumAnswers
    UPDATE "User"
    SET "num_answers" = "num_answers" - 1
    WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = OLD."id") AND "deleted" = false;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_answer_trigger
AFTER DELETE ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE rem_answer_trigger(); 

--   %%% COMMENT

CREATE FUNCTION add_comment_trigger() RETURNS TRIGGER AS
$BODY$
DECLARE 
  username1 text;
BEGIN
  --
  -- NumComments
  UPDATE "User"
  SET "num_comments" = "num_comments" + 1
  WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id") AND "deleted" = false;

  IF (SELECT "deleted" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."id") = false THEN 

    username1 := (SELECT "username" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."id");

    --
    -- Notification Table
    WITH "not" AS(
      INSERT INTO "Notification"("text", "user_id")
      VALUES (username1 || ' has commented your answer', (SELECT "user_id" FROM "Content" WHERE "id" = NEW."answer_id"))
      RETURNING "id"
    )
    
    -- Comment Notification Table
    INSERT INTO "CommentNotification"("id", "comment_id")
    VALUES ((SELECT "id" FROM "not"), NEW."id");
  END IF;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_comment_trigger
AFTER INSERT ON "Comment"
FOR EACH ROW
EXECUTE PROCEDURE add_comment_trigger(); 

CREATE FUNCTION rem_comment_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
    --
    -- NumComments
    UPDATE "User"
    SET "num_comments" = "num_comments" - 1
    WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = OLD."id") AND "deleted" = false;
	
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_comment_trigger
AFTER DELETE ON "Comment"
FOR EACH ROW
EXECUTE PROCEDURE rem_comment_trigger(); 

--   %%% FAV_ANSWER

CREATE FUNCTION add_fav_answer_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  --
  -- NumFavAnswers
  UPDATE "User"
  SET "num_fav_answers" = "num_fav_answers" + 1
  WHERE (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id") = "id" AND "deleted" = false;

    IF NEW."selected" = true AND OLD."selected" = false AND (SELECT "deleted" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."id") = false THEN

      --
      -- Notification Table
      WITH "not" AS(
        INSERT INTO "Notification"("text", "user_id")
        VALUES ('Your answer was selected as favourite', (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id"))
        RETURNING "id"
      )

      -- FavouriteAnswer Notification Table
      INSERT INTO "FavouriteAnswerNotification"("id", "answer_id")
      VALUES ((SELECT "id" FROM "not"), NEW."id");
    END IF;

	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER add_fav_answer_trigger
AFTER UPDATE ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE add_fav_answer_trigger(); 

CREATE FUNCTION rem_fav_answer_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN

	IF NEW."selected" THEN
		--Remove favourite if exists from answer
		UPDATE "Answer"
		SET "selected" = false
		WHERE "selected" = true AND NEW."id" <> "id" AND NEW."question_id" = "question_id";
	END IF;
	
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rem_fav_answer_trigger
BEFORE UPDATE ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE rem_fav_answer_trigger(); 

CREATE FUNCTION red_num_fav_answer_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW."selected" = false AND OLD."selected" = true THEN
      --
      -- NumFavAnswers
      UPDATE "User"
      SET "num_fav_answers" = "num_fav_answers" - 1
      WHERE (SELECT "user_id" FROM "Content" WHERE "id" = NEW."id") = "id" AND "deleted" = false;
    END IF;
		
	RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER red_num_fav_answer_trigger
AFTER UPDATE ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE red_num_fav_answer_trigger();

--   %%% MOD_APLICATION

CREATE FUNCTION mod_application_decision_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF (SELECT "deleted" FROM "User" WHERE "User"."id" = NEW."user_id") = false THEN
    IF OLD."status" <> 'pending' THEN
        RAISE EXCEPTION 'This request was already processed.';
    END IF;
    
    IF NEW."status" = 'accepted' AND OLD."status" <> 'accepted' THEN
      WITH "not" AS(
      INSERT INTO "Notification"("text", "user_id")
      VALUES ('Your request to be mod was accepted', NEW."user_id")
      RETURNING "id"
      )
    
      -- Mod Notification Table
      INSERT INTO "ModNotification"("id")
      VALUES ((SELECT "id" FROM "not"));

      INSERT INTO "Mod" ("id", "num_interactions")
      VALUES (NEW."user_id", 0);


    ELSIF NEW."status" = 'rejected' AND OLD."status" <> 'rejected' THEN
      WITH "not" AS(
      INSERT INTO "Notification"("text", "user_id")
      VALUES ('Your request to be mod was rejected', NEW."user_id")
      RETURNING "id"
    )
    
      -- Mod Notification Table
      INSERT INTO "ModNotification"("id")
      VALUES ((SELECT "id" FROM "not"));

      DELETE FROM "Mod"
      WHERE "id" = NEW."user_id";

    END IF;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER mod_application_decision_trigger
AFTER UPDATE ON "ModApplication"
FOR EACH ROW
EXECUTE PROCEDURE mod_application_decision_trigger();

CREATE FUNCTION can_app_mod_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS (SELECT * FROM "Mod" WHERE "id" = NEW."user_id") THEN 
    RAISE EXCEPTION 'You are already a mod';
  END IF;

  IF (SELECT "trust_level" FROM "User" WHERE "id" = NEW."user_id") < 3500 THEN 
    RAISE EXCEPTION 'Your trust level is not high enough! Trust level >= 3500';
  END IF;

  IF EXISTS(SELECT * FROM "ModApplication" WHERE "user_id" = NEW."user_id" AND "status" = 'pending') THEN
    RAISE EXCEPTION 'You have a pending application';
  END IF;

  IF EXISTS(SELECT * FROM "ModApplication" WHERE "user_id" = NEW."user_id") THEN 
    IF (SELECT EXTRACT(MONTH FROM AGE(NOW(), (SELECT calc_last_app_date(NEW."user_id"))))) < 1 AND (SELECT EXTRACT(YEAR FROM AGE(NOW(), (SELECT calc_last_app_date(NEW."user_id"))))) = 0 THEN
      RAISE EXCEPTION 'It has not been enough time since your last application! Needed one month at least';
    END IF;
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER can_app_mod_trigger
BEFORE INSERT ON "ModApplication"
FOR EACH ROW
EXECUTE PROCEDURE can_app_mod_trigger(); 

--   %%% INSERTED QUESTION WITH FOLLOWED TAGS

CREATE FUNCTION insert_question_with_followed_tag_trigger() RETURNS TRIGGER AS
$BODY$
DECLARE
    aux "FollowedTags"%rowtype;
    tag1 text;
    username1 text;
BEGIN


  UPDATE "Tag"
  SET "equalTagsCnt" = (SELECT COUNT(*) FROM "TaggedQuestion" WHERE "tag_id" = NEW."tag_id")
  WHERE "Tag"."id" = NEW."tag_id";
  
  FOR aux IN SELECT * FROM "FollowedTags" WHERE "FollowedTags"."tag_id" = NEW."tag_id"
  LOOP
      tag1 := (SELECT "text" FROM "Tag" WHERE "id" = NEW."tag_id");
      username1 := (SELECT "username" FROM "User", "Content" WHERE "User"."id" = "Content"."user_id" AND "Content"."id" = NEW."question_id");

      IF (SELECT "deleted" FROM "User" WHERE "User"."id" = aux."user_id") = false THEN
        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES (username1 || ' has entered a question with a tag: ' || tag1, aux."user_id")
          RETURNING "id"
        )
        
        -- Comment Notification Table
        INSERT INTO "TagNotification"("id", "tag_id")
        VALUES ((SELECT "id" FROM "not"), NEW."tag_id");
      END IF;
  END LOOP;
  
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER insert_question_with_followed_tag_trigger
AFTER INSERT ON "TaggedQuestion"
FOR EACH ROW
EXECUTE PROCEDURE insert_question_with_followed_tag_trigger();

--   %%% EARN BADGE

CREATE FUNCTION earn_badge_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW."deleted" = false THEN
    IF OLD."num_votes" <> NEW."num_votes" THEN
      IF OLD."num_votes" < 500 AND NEW."num_votes" >= 500 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 1 AND "badge_id" <= 5);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 5);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Voting Grandmaster', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 5);
      ELSIF OLD."num_votes" < 200 AND NEW."num_votes" >= 200 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 1 AND "badge_id" <= 5);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 4);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Voting Master', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 4);
      ELSIF OLD."num_votes" < 100 AND NEW."num_votes" >= 100 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 1 AND "badge_id" <= 5);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 3);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Voting Expert', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 3);
      ELSIF OLD."num_votes" < 30 AND NEW."num_votes" >= 30 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 1 AND "badge_id" <= 5);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 2);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Voting Junior', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 2);
      ELSIF OLD."num_votes" < 10 AND NEW."num_votes" >= 10 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 1 AND "badge_id" <= 5);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 1);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Voting Newbie', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 1);
      END IF;
    END IF;

    IF OLD."num_questions" <> NEW."num_questions" THEN
      IF OLD."num_questions" < 100 AND NEW."num_questions" >= 100 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 11 AND "badge_id" <= 15);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 15);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Questioning Grandmaster', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 15);
      ELSIF OLD."num_questions" < 50 AND NEW."num_questions" >= 50 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 11 AND "badge_id" <= 15);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 14);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Questioning Master', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 14);
      ELSIF OLD."num_questions" < 20 AND NEW."num_questions" >= 20 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 11 AND "badge_id" <= 15);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 13);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Questioning Expert', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 13);
      ELSIF OLD."num_questions" < 10 AND NEW."num_questions" >= 10 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 11 AND "badge_id" <= 15);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 12);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Questioning Junior', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 12);
      ELSIF OLD."num_questions" < 2 AND NEW."num_questions" >= 2 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 11 AND "badge_id" <= 15);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 11);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Questioning Newbie', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 11);
      END IF;
    END IF;

    IF OLD."num_comments" <> NEW."num_comments" THEN
      IF OLD."num_comments" < 200 AND NEW."num_comments" >= 200 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 16 AND "badge_id" <= 20);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 20);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Commenting Grandmaster', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 20);
      ELSIF OLD."num_comments" < 100 AND NEW."num_comments" >= 100 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 16 AND "badge_id" <= 20);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 19);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Commenting Master', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 19);
      ELSIF OLD."num_comments" < 70 AND NEW."num_comments" >= 70 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 16 AND "badge_id" <= 20);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 18);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Commenting Expert', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 18);
      ELSIF OLD."num_comments" < 50 AND NEW."num_comments" >= 50 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 16 AND "badge_id" <= 20);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 17);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Commenting Junior', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 17);
      ELSIF OLD."num_comments" < 20 AND NEW."num_comments" >= 20 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 16 AND "badge_id" <= 20);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 16);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Commenting Newbie', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 16);
      END IF;
    END IF;

    IF OLD."num_answers" <> NEW."num_answers" THEN
      IF OLD."num_answers" < 200 AND NEW."num_answers" >= 200 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 6 AND "badge_id" <= 10);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 10);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Answering Grandmaster', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 10);
      ELSIF OLD."num_answers" < 100 AND NEW."num_answers" >= 100 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 6 AND "badge_id" <= 10);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 9);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Answering Master', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 9);
      ELSIF OLD."num_answers" < 50 AND NEW."num_answers" >= 50 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 6 AND "badge_id" <= 10);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 8);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Answering Expert', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 8);
      ELSIF OLD."num_answers" < 30 AND NEW."num_answers" >= 30 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 6 AND "badge_id" <= 10);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 7);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Answering Junior', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 7);
      ELSIF OLD."num_answers" < 10 AND NEW."num_answers" >= 10 THEN
        DELETE FROM "EarnedBadge"
        WHERE "user_id" = NEW."id" AND ("badge_id" >= 6 AND "badge_id" <= 10);

        INSERT INTO "EarnedBadge" ("user_id", "badge_id")
        VALUES (NEW."id", 6);

        --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('You have earned a new badge: Answering Newbie', NEW."id")
          RETURNING "id"
        )
        
        INSERT INTO "BadgeNotification"("id", "badge_id")
        VALUES ((SELECT "id" FROM "not"), 6);
      END IF;
    END IF;
  END IF;

  RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER earn_badge_trigger
AFTER UPDATE ON "User"
FOR EACH ROW
EXECUTE PROCEDURE earn_badge_trigger();

--   %%% TRUST_LEVEL

CREATE FUNCTION update_trust_level_trigger() RETURNS TRIGGER AS
$BODY$
DECLARE
    num_questions1 integer;
    num_answers1 integer;
    num_comments1 integer;
    num_fav_answers1 integer;
    num_reports1 integer;
BEGIN
  IF OLD."deleted" = false THEN
    IF (OLD."num_questions" <> NEW."num_questions"
    OR OLD."num_answers" <> NEW."num_answers"
    OR OLD."num_comments" <> NEW."num_comments"
    OR OLD."num_fav_answers" <> NEW."num_fav_answers"
    OR OLD."num_reports" <> NEW."num_reports") AND NEW."deleted" = false
    THEN
      num_questions1 := (SELECT "num_questions" FROM "User" WHERE "id" = NEW."id");
      num_answers1 := (SELECT "num_answers" FROM "User" WHERE "id" = NEW."id");
      num_comments1 := (SELECT "num_comments" FROM "User" WHERE "id" = NEW."id");
      num_fav_answers1 := (SELECT "num_fav_answers" FROM "User" WHERE "id" = NEW."id");
      num_reports1 := (SELECT "num_reports" FROM "User" WHERE "id" = NEW."id");

      UPDATE "User"
      SET "trust_level" = 10 * num_questions1 + 10 * num_answers1 + 10 * num_comments1 + 50 * num_fav_answers1 - 70 * num_reports1
      WHERE "id" = NEW."id";
    END IF;
  END IF;

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_trust_level_trigger
AFTER UPDATE ON "User"
FOR EACH ROW
EXECUTE PROCEDURE update_trust_level_trigger(); 

--   %%% DISJOINT_NOTIFICATION

CREATE FUNCTION disjoint_badge_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on badge notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_badge_not_trigger
BEFORE INSERT ON "BadgeNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_badge_not_trigger();

CREATE FUNCTION disjoint_comment_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on comment notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_comment_not_trigger
BEFORE INSERT ON "CommentNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_comment_not_trigger();

CREATE FUNCTION disjoint_answer_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on answer notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_answer_not_trigger
BEFORE INSERT ON "AnswerNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_answer_not_trigger();

CREATE FUNCTION disjoint_tag_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on tag notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_tag_not_trigger
BEFORE INSERT ON "TagNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_tag_not_trigger();

CREATE FUNCTION disjoint_fav_answer_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on favourite answer notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_fav_answer_not_trigger
BEFORE INSERT ON "FavouriteAnswerNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_fav_answer_not_trigger();

CREATE FUNCTION disjoint_mod_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ReportNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on mod notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_mod_not_trigger
BEFORE INSERT ON "ModNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_mod_not_trigger();

CREATE FUNCTION disjoint_report_not_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "ModNotification" WHERE "id" = NEW."id") 
  OR EXISTS(SELECT * FROM "FavouriteAnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "TagNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "AnswerNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "CommentNotification" WHERE "id" = NEW."id")
  OR EXISTS(SELECT * FROM "BadgeNotification" WHERE "id" = NEW."id")
  THEN
    RAISE EXCEPTION 'Cannot insert on report notification! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_report_not_trigger
BEFORE INSERT ON "ReportNotification"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_report_not_trigger();

--   %%% DISJOINT_CONTENT

CREATE FUNCTION disjoint_question_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "Answer" WHERE "id" = NEW."id") OR EXISTS(SELECT * FROM "Comment" WHERE "id" = NEW."id") THEN
    RAISE EXCEPTION 'Cannot insert on question! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_question_trigger
BEFORE INSERT ON "Question"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_question_trigger();

CREATE FUNCTION disjoint_answer_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "Question" WHERE "id" = NEW."id") OR EXISTS(SELECT * FROM "Comment" WHERE "id" = NEW."id") THEN
    RAISE EXCEPTION 'Cannot insert on answer! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_answer_trigger
BEFORE INSERT ON "Answer"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_answer_trigger(); 

CREATE FUNCTION disjoint_comment_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM "Question" WHERE "id" = NEW."id") OR EXISTS(SELECT * FROM "Answer" WHERE "id" = NEW."id") THEN
    RAISE EXCEPTION 'Cannot insert on comment! Disjoint generalization';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER disjoint_comment_trigger
BEFORE INSERT ON "Comment"
FOR EACH ROW
EXECUTE PROCEDURE disjoint_comment_trigger();

--   %%% REPORT_NOTIFCATION

CREATE FUNCTION report_notification_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NEW."status" = 'ignore_report' AND (SELECT "deleted" FROM "User" WHERE "id" = NEW."user_id") = false THEN  
      --
      -- Notification Table
      WITH "not" AS(
        INSERT INTO "Notification"("text", "user_id")
        VALUES ('We decided to ignore your report!', NEW."user_id")
        RETURNING "id"
        )
        
        -- Report Notification Table
        INSERT INTO "ReportNotification"("id", "report_id")
        VALUES ((SELECT "id" FROM "not"), NEW."id");
    ELSIF NEW."status" = 'delete_content' THEN
      IF (SELECT "deleted" FROM "Content", "User" WHERE "Content"."id" = NEW."content_id" AND "User"."id" = "Content"."user_id") = false THEN
          --
        -- Notification Table
        WITH "not" AS(
          INSERT INTO "Notification"("text", "user_id")
          VALUES ('Based in one report we decide to delete your content!', (SELECT "user_id" FROM "Content" WHERE "id" = NEW."content_id"))
          RETURNING "id"
        )
        
        -- Report Notification Table
        INSERT INTO "ReportNotification"("id", "report_id")
        VALUES ((SELECT "id" FROM "not"), NEW."id");
      END IF;
    END IF;

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER report_notification_trigger
AFTER UPDATE ON "Report"
FOR EACH ROW
EXECUTE PROCEDURE report_notification_trigger();

--   %%% DELETE_USER
CREATE FUNCTION delete_user_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NEW."deleted" <> OLD."deleted" THEN
    -- Remove from Mod
    DELETE FROM "Mod"
    WHERE "id" = NEW."id";

    -- Remove mod applications not processed
    DELETE FROM "ModApplication"
    WHERE "user_id" = NEW."id" AND "status" = 'pending';

    -- Remove path to profile image
    DELETE FROM "UserImage"
    WHERE "id" = OLD."profile_picture_id";

    -- Remove all notifications directed to him
    DELETE FROM "Notification"
    WHERE "user_id" = NEW."id";

    -- Remove all reports made by him that were not processed yet
    DELETE FROM "Report"
    WHERE "user_id" = NEW."id" AND "status" = 'pending';

    -- Remove all badges that he earned
    DELETE FROM "EarnedBadge"
    WHERE "user_id" = NEW."id";

    -- Remove all tags that he followed
    DELETE FROM "FollowedTags"
    WHERE "user_id" = NEW."id";
  END IF;

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_user_trigger
AFTER UPDATE ON "User"
FOR EACH ROW
EXECUTE PROCEDURE delete_user_trigger();

--   %%% DELETE_CONTENT

CREATE FUNCTION delete_content_trigger() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF (SELECT "score" FROM "Content" WHERE "id" = OLD."id") >= 10 OR (SELECT calc_num_interactions_on_content(OLD."id")) >= 2 THEN
    RAISE EXCEPTION 'Can not delete this content! Number of votes >= 10 or number of answer and comments >= 2';
  END IF;

  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_content_trigger
BEFORE DELETE ON "Content"
FOR EACH ROW
EXECUTE PROCEDURE delete_content_trigger();

/*      ---------------------- PROCEDURES  ----------------------      */

CREATE PROCEDURE add_question(a1 text, b1 int, c1 text)
LANGUAGE plpgsql
AS $BODY$
BEGIN
  -- Inserts into Content Table
  WITH "cont" AS(
    INSERT INTO "Content" ("text", "user_id")
    VALUES (a1, b1)
    RETURNING "id"
  )
  
  -- Inserts into Question Table
  INSERT INTO "Question" ("id", "title")
  VALUES ((SELECT "id" FROM "cont"), c1);
END
$BODY$;

CREATE PROCEDURE add_answer(a1 text, b1 int, c1 int)
LANGUAGE plpgsql
AS $BODY$
BEGIN
  -- Inserts into Content Table
  WITH "cont" AS(
    INSERT INTO "Content" ("text", "user_id")
    VALUES (a1, b1)
    RETURNING "id"
  )
  
  -- Inserts into Answer Table
  INSERT INTO "Answer" ("id", "question_id")
  VALUES ((SELECT "id" FROM "cont"), c1);
END
$BODY$;

CREATE PROCEDURE add_comment(a1 text, b1 int, c1 int)
LANGUAGE plpgsql
AS $BODY$
BEGIN
  -- Inserts into Content Table
  WITH "cont" AS(
  INSERT INTO "Content" ("text", "user_id")
  VALUES (a1, b1)
  RETURNING "id"
  )

  -- Inserts into Comment Table
  INSERT INTO "Comment" ("id", "answer_id")
  VALUES ((SELECT "id" FROM "cont"), c1);
END
$BODY$;

CREATE PROCEDURE treat_report(id1 integer, decision1 text, mod1 integer)
LANGUAGE plpgsql
AS $BODY$
BEGIN

  IF decision1 = 'pending' THEN
		RAISE EXCEPTION 'Cannot put report pending.';
	END IF;

  IF (SELECT "status" FROM "Report" WHERE "id" = id1) <> 'pending' THEN
      RAISE EXCEPTION 'This report was already processed.';
  END IF;

  IF mod1 IS NULL THEN
    RAISE EXCEPTION 'Needed to specify which mod treated this report.';
  END IF;
  
  UPDATE "Mod"
  SET "num_interactions" = "num_interactions" + 1
  WHERE "id" = mod1;
  
  IF decision1 = 'delete_content' OR decision1 = 'ban_author' THEN
    IF decision1 = 'delete_content' THEN
      UPDATE "Report"
      SET "status" = 'delete_content', "mod_id" = mod1
      WHERE "status" = 'pending' AND "content_id" = (SELECT "content_id" FROM "Report" WHERE "id" = id1); 

      UPDATE "User"
      SET "num_reports" = "num_reports" + 1
      WHERE "id" = (SELECT "user_id" FROM "Content" WHERE "id" = (SELECT "content_id" FROM "Report" WHERE "id" = id1));
	  
      UPDATE "Content"
      SET "visible" = false
      WHERE "id" = (SELECT "content_id" FROM "Report" WHERE "id" = id1);
    ELSIF decision1 = 'ban_author' THEN
      UPDATE "Report"
      SET "status" = 'ban_author', "mod_id" = mod1
      WHERE "status" = 'pending' AND "content_id" = (SELECT "content_id" FROM "Report" WHERE "id" = id1); 

      id1 := (SELECT "user_id" FROM "Content" WHERE "id" = (SELECT "content_id" FROM "Report" WHERE "id" = id1));

      WHILE EXISTS(SELECT "username" FROM "User" WHERE "username" = ('deleted' || id1)) LOOP
        id1 := id1 + 1;
      END LOOP;
    
      -- deletes a user from the database
      UPDATE "User"
      SET "username" = 'deleted' || id1,
          "email" = 'deleted' || id1,
          "name" = 'deleted' || id1,
          "password" = 'deleted' || id1,
          "trust_level" = 0,
          "country" = 'deleted' || id1,
          "bio" = NULL,
          "erasmus_in_out" = NULL,
          "profile_picture_id" = NULL,
          "birthday" = '1990-01-01',
          "num_votes" = 0,
          "num_questions" = 0,
          "num_comments" = 0,
          "num_reports" = 0,
          "num_answers" = 0,
          "num_fav_answers" = 0,
          "deleted" = true
      WHERE "id" = id1;

    END IF;
  ELSIF decision1 = 'ignore_report' THEN
    UPDATE "Report"
    SET "status" = 'ignore_report', "mod_id" = mod1
    WHERE "id" = id1; 
  END IF;
END
$BODY$;

/*      ---------------------- AUXILIAR  ----------------------      */

CREATE FUNCTION calc_num_interactions_on_content(id_content1 integer) RETURNS integer AS
$BODY$
DECLARE
	aux "Answer"%rowtype;
  num_interactions1 integer;
BEGIN
  IF EXISTS (SELECT * FROM "Question" WHERE "id" = id_content1) THEN
  	num_interactions1 := 0;
    FOR aux IN SELECT * FROM "Answer" WHERE "question_id" = id_content1
    LOOP
      num_interactions1 := num_interactions1 + 1 + (SELECT calc_num_interactions_on_content(aux."id"));
    END LOOP;
    RETURN num_interactions1;
  ELSIF EXISTS (SELECT * FROM "Answer" WHERE "id" = id_content1) THEN
  	RETURN (SELECT COUNT(*) FROM "Comment" WHERE "answer_id" = id_content1);
  ELSE 
  	RETURN 0;
  END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE FUNCTION calc_last_app_date(id_user1 integer) RETURNS timestamp AS
$BODY$
DECLARE
	aux "ModApplication"%rowtype;
  last_date1 timestamp;
BEGIN
	last_date1 := timestamp '1999-1-1';
  FOR aux IN SELECT * FROM "ModApplication" WHERE "user_id" = id_user1
  LOOP
  raise notice 'entrei';
  IF last_date1 < aux."timestamp" THEN
    last_date1 := aux."timestamp";
  END IF;
  END LOOP;
  return last_date1;
END
$BODY$
LANGUAGE plpgsql;

/*      ---------------------- INDEXES  ----------------------      */

CREATE INDEX big_search_idx ON "big_search" USING GIST("search");

CREATE INDEX active_users_idx ON "User" USING btree("deleted") WHERE "deleted" = false;

CREATE INDEX visible_content_idx ON "Content" USING btree("visible") WHERE "visible" = true;

CREATE INDEX pending_reports_idx ON "Report" USING btree("status") WHERE "status" = 'pending';

CREATE INDEX pending_applications_idx ON "ModApplication" USING btree("status") WHERE "status" = 'pending';






